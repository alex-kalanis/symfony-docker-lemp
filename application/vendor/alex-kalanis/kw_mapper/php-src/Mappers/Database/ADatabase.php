<?php

namespace kalanis\kw_mapper\Mappers\Database;


use kalanis\kw_mapper\Interfaces\IQueryBuilder;
use kalanis\kw_mapper\MapperException;
use kalanis\kw_mapper\Mappers\AMapper;
use kalanis\kw_mapper\Records\ARecord;
use kalanis\kw_mapper\Records\TFill;
use kalanis\kw_mapper\Storage;


/**
 * Class ADatabase
 * @package kalanis\kw_mapper\Mappers\Database
 */
abstract class ADatabase extends AMapper
{
    use TFill;
    use TTable;

    /** @var Storage\Database\ASQL */
    protected $database = null;
    /** @var Storage\Database\Dialects\ADialect */
    protected $dialect = null;
    /** @var Storage\Database\QueryBuilder */
    protected $queryBuilder = null;

    /**
     * @throws MapperException
     */
    public function __construct()
    {
        parent::__construct();
        $config = Storage\Database\ConfigStorage::getInstance()->getConfig($this->getSource());
        $this->database = Storage\Database\DatabaseSingleton::getInstance()->getDatabase($config);
        $this->dialect = Storage\Database\Dialects\Factory::getInstance()->getDialectClass($this->database->languageDialect());
        $this->queryBuilder = new Storage\Database\QueryBuilder($this->dialect);
    }

    public function getAlias(): string
    {
        return $this->getTable();
    }

    protected function insertRecord(ARecord $record): bool
    {
        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($record as $key => $item) {
            if (isset($this->relations[$key]) && (false !== $item)) {
                $this->queryBuilder->addProperty($this->getTable(), $this->relations[$key], $item);
            }
        }
        return $this->database->exec(strval($this->dialect->insert($this->queryBuilder)), $this->queryBuilder->getParams());
    }

    protected function updateRecord(ARecord $record): bool
    {
        if ($this->updateRecordByPk($record)) {
            return true;
        }
        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($record as $key => $item) {
            if (isset($this->relations[$key]) && (false !== $item)) {
                if ($record->getEntry($key)->isFromStorage()) {
                    $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
                } else {
                    $this->queryBuilder->addProperty($this->getTable(), $this->relations[$key], $item);
                }
            }
        }
        return $this->database->exec(strval($this->dialect->update($this->queryBuilder)), $this->queryBuilder->getParams());
    }

    /**
     * @param ARecord $record
     * @throws MapperException
     * @return bool
     */
    protected function updateRecordByPk(ARecord $record): bool
    {
        if (empty($this->primaryKeys)) {
            return false;
        }

        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($this->primaryKeys as $key) {
            try {
                if (isset($this->relations[$key])) {
                    $entry = $record->getEntry($key);
                    if ($entry->isFromStorage() && (false !== $entry->getData())) {
                        $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $entry->getData());
                    }
                }
            } catch (MapperException $ex) {
                return false;
            }
        }

        if (empty($this->queryBuilder->getConditions())) { // no conditions, nothing in PKs - back to normal system
            return false;
        }

        foreach ($record as $key => $item) {
            if (isset($this->relations[$key])) {
                $entry = $record->getEntry($key);
                if (!in_array($key, $this->primaryKeys) && !$entry->isFromStorage() && (false !== $item)) {
                    $this->queryBuilder->addProperty($this->getTable(), $this->relations[$key], $item);
                }
            }
        }
        return $this->database->exec(strval($this->dialect->update($this->queryBuilder)), $this->queryBuilder->getParams());
    }

    protected function loadRecord(ARecord $record): bool
    {
        if ($this->loadRecordByPk($record)) {
            return true;
        }

        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());

        // conditions - must be equal
        foreach ($record as $key => $item) {
            if (isset($this->relations[$key]) && (false !== $item)) {
                $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
            }
        }

        // relations - what to get
        foreach ($this->relations as $localAlias => $remoteColumn) {
            $this->queryBuilder->addColumn($this->getTable(), $remoteColumn, $localAlias);
        }
        $this->queryBuilder->setLimits(0,1);

        // query itself
        $lines = $this->database->query(strval($this->dialect->select($this->queryBuilder)), $this->queryBuilder->getParams());
        if (empty($lines)) {
            return false;
        }

        // fill entries in record
        $line = reset($lines);
        foreach ($line as $index => $item) {
            $entry = $record->getEntry($index);
            $entry->setData($this->typedFillSelection($entry, $item), true);
        }
        return true;
    }

    /**
     * @param ARecord $record
     * @throws MapperException
     * @return bool
     */
    protected function loadRecordByPk(ARecord $record): bool
    {
        if (empty($this->primaryKeys)) {
            return false;
        }

        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());

        // conditions - everything must be equal
        foreach ($this->primaryKeys as $key) {
            try {
                if (isset($this->relations[$key])) {
                    $item = $record->offsetGet($key);
                    if (false !== $item) {
                        $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
                    }
                }
            } catch (MapperException $ex) {
                return false;
            }
        }

        if (empty($this->queryBuilder->getConditions())) { // no conditions, nothing in PKs - back to normal system
            return false;
        }

        // relations - what to get
        foreach ($this->relations as $localAlias => $remoteColumn) {
            $this->queryBuilder->addColumn($this->getTable(), $remoteColumn, $localAlias);
        }

        // query itself
        $this->queryBuilder->setLimits(0,1);
        $lines = $this->database->query(strval($this->dialect->select($this->queryBuilder)), $this->queryBuilder->getParams());
        if (empty($lines)) {
            return false;
        }

        // fill entries in record
        $line = reset($lines);
        foreach ($line as $index => $item) {
            $entry = $record->getEntry($index);
            $entry->setData($this->typedFillSelection($entry, $item), true);
        }
        return true;
    }

    public function countRecord(ARecord $record): int
    {
        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($record as $key => $item) {
            if (isset($this->relations[$key]) && (false !== $item)) {
                $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
            }
        }

        if (empty($this->primaryKeys)) {
            $relation = reset($this->relations);
            if (false !== $relation) {
                $this->queryBuilder->addColumn($this->getTable(), $relation, 'count', IQueryBuilder::AGGREGATE_COUNT);
            }
        } else {
//            foreach ($this->primaryKeys as $primaryKey) {
//                $this->queryBuilder->addColumn($this->getTable(), $primaryKey, '', IQueryBuilder::AGGREGATE_COUNT);
//            }
            $key = reset($this->primaryKeys);
            $this->queryBuilder->addColumn($this->getTable(), $this->relations[$key], 'count', IQueryBuilder::AGGREGATE_COUNT);
        }

        $lines = $this->database->query(strval($this->dialect->select($this->queryBuilder)), $this->queryBuilder->getParams());
        if (empty($lines) || !is_iterable($lines)) {
            // @codeCoverageIgnoreStart
            return 0;
        }
        // @codeCoverageIgnoreEnd
        $line = reset($lines);
        return intval(reset($line));
    }

    protected function deleteRecord(ARecord $record): bool
    {
        if ($this->deleteRecordByPk($record)) {
            return true;
        }

        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($record as $key => $item) {
            if (isset($this->relations[$key]) && (false !== $item)) {
                $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
            }
        }
        return $this->database->exec(strval($this->dialect->delete($this->queryBuilder)), $this->queryBuilder->getParams());
    }

    /**
     * @param ARecord $record
     * @throws MapperException
     * @return bool
     */
    protected function deleteRecordByPk(ARecord $record): bool
    {
        if (empty($this->primaryKeys)) {
            return false;
        }

        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($this->primaryKeys as $key) {
            try {
                if (isset($this->relations[$key])) {
                    $item = $record->offsetGet($key);
                    if (false !== $item) {
                        $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
                    }
                }
            } catch (MapperException $ex) {
                return false;
            }
        }

        if (empty($this->queryBuilder->getConditions())) { // no conditions, nothing in PKs - back to normal system
            return false;
        }

        return $this->database->exec(strval($this->dialect->delete($this->queryBuilder)), $this->queryBuilder->getParams());
    }

    public function loadMultiple(ARecord $record): array
    {
        $this->queryBuilder->clear();
        $this->queryBuilder->setBaseTable($this->getTable());
        foreach ($record as $key => $item) {
            if (isset($this->relations[$key]) && (false !== $item)) {
                $this->queryBuilder->addCondition($this->getTable(), $this->relations[$key], IQueryBuilder::OPERATION_EQ, $item);
            }
        }

        // relations - what to get
        foreach ($this->relations as $localAlias => $remoteColumn) {
            $this->queryBuilder->addColumn($this->getTable(), $remoteColumn, $localAlias);
        }

        // query itself
        $lines = $this->database->query(strval($this->dialect->select($this->queryBuilder)), $this->queryBuilder->getParams());
        if (empty($lines)) {
            return [];
        }

        $result = [];
        foreach ($lines as $line) {
            $rec = clone $record;
            foreach ($line as $index => $item) {
                $entry = $rec->getEntry($index);
                $entry->setData($this->typedFillSelection($entry, $item), true);
            }
            $result[] = $rec;
        }
        return $result;
    }
}

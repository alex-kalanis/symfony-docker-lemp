<?php

namespace kalanis\kw_connect\search;


use kalanis\kw_connect\core\AConnector;
use kalanis\kw_connect\core\Interfaces\IFilterFactory;
use kalanis\kw_connect\core\Interfaces\IFilterSubs;
use kalanis\kw_connect\core\Interfaces\IIterableConnector;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_connect\core\Interfaces\IRow;
use kalanis\kw_mapper\Interfaces\IQueryBuilder;
use kalanis\kw_mapper\MapperException;
use kalanis\kw_mapper\Records\ARecord;
use kalanis\kw_mapper\Search\Search as MapperSearch;


/**
 * Class Connector
 * @package kalanis\kw_table\Connector\Sources
 * Data source is kw_mapper/Search
 */
class Connector extends AConnector implements IIterableConnector
{
    /** @var MapperSearch */
    public $dataSource;

    /** @var ARecord[] */
    protected $rawData = [];

    /** @var bool */
    protected $dataFetched = false;

    public function __construct(MapperSearch $search)
    {
        $this->dataSource = $search;
    }

    /**
     * @throws MapperException
     */
    protected function parseData(): void
    {
        foreach ($this->rawData as $mapper) {
            $this->translatedData[$this->getPrimaryKey($mapper)] = $this->getTranslated($mapper);
        }
    }

    protected function getTranslated(ARecord $data): IRow
    {
        return new Row($data);
    }

    /**
     * @param ARecord $record
     * @throws MapperException
     * @return string
     */
    protected function getPrimaryKey(ARecord $record): string
    {
        $pks = $record->getMapper()->getPrimaryKeys();
        $values = [];
        foreach ($pks as $pk) {
            $values[] = strval($record->offsetGet($pk));
        }
        return implode('_', $values);
    }

    public function setFiltering(string $colName, string $filterType, $value): void
    {
        $type = $this->getFilterFactory()->getFilter($filterType);
        if ($type instanceof IFilterSubs) {
            $type->addFilterFactory($this->getFilterFactory());
        }
        $type->setDataSource($this->dataSource);
        $type->setFiltering($colName, $value);
    }

    /**
     * @param string $colName
     * @param string $direction
     * @throws MapperException
     */
    public function setOrdering(string $colName, string $direction): void
    {
        $this->dataSource->orderBy(
            $colName,
            IOrder::ORDER_ASC == $direction ? IQueryBuilder::ORDER_ASC : IQueryBuilder::ORDER_DESC
        );
    }

    public function setPagination(?int $offset, ?int $limit): void
    {
        $this->dataSource->offset($offset);
        $this->dataSource->limit($limit);
    }

    /**
     * @throws MapperException
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->dataSource->getCount();
    }

    /**
     * @throws MapperException
     */
    public function fetchData(): void
    {
        $this->rawData = $this->dataSource->getResults();
        $this->parseData();
    }

    public function getFilterFactory(): IFilterFactory
    {
        return Filters\Factory::getInstance();
    }
}

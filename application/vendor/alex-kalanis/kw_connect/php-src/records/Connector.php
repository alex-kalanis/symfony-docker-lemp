<?php

namespace kalanis\kw_connect\records;


use kalanis\kw_connect\arrays\Filters;
use kalanis\kw_connect\core\AConnector;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IFilterFactory;
use kalanis\kw_connect\core\Interfaces\IIterableConnector;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_connect\core\Interfaces\IRow;
use kalanis\kw_mapper\Records\ARecord;


/**
 * Class Connector
 * @package kalanis\kw_connect\records
 * Data source is kw_mapper/Record
 */
class Connector extends AConnector implements IIterableConnector
{
    /** @var ARecord[] */
    protected $dataSource;
    /** @var array<IRow> */
    protected $filteredData = [];
    /** @var string */
    protected $orderDirection = IOrder::ORDER_ASC;
    /** @var string */
    protected $orderColumn = '';
    /** @var string|null */
    protected $filterByColumn = null;
    /** @var string|int|null */
    protected $filterByNamePart = null;
    /** @var int|null */
    protected $offset = null;
    /** @var int|null */
    protected $limit = null;

    /**
     * @param array<ARecord> $records
     */
    public function __construct(array $records)
    {
        $this->dataSource = $records;
    }

    protected function parseData(): void
    {
        $filtered = array_filter(array_map([$this, 'getTranslated'], $this->dataSource), [$this, 'filterItems']);
        uasort($filtered, [$this, 'sortItems']);
        $this->filteredData = $filtered;
        $this->translatedData = array_slice($filtered, intval($this->offset), $this->limit);
    }

    public function getTranslated(ARecord $data): IRow
    {
        return new Row($data);
    }

    public function setFiltering(string $colName, string $filterType, $value): void
    {
        $this->filterByColumn = $colName;
        $this->filterByNamePart = is_array($value) ? strval(reset($value)) : strval($value);
    }

    public function setOrdering(string $colName, string $direction): void
    {
        $this->orderColumn = $colName;
        $this->orderDirection = $direction;
    }

    public function setPagination(?int $offset, ?int $limit): void
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getTotalCount(): int
    {
        if (empty($this->dataSource)) {
            return 0;
        }
        if (empty($this->filteredData)) {
            $this->fetchData();
        }
        return count($this->filteredData);
    }

    public function fetchData(): void
    {
        $this->parseData();
    }

    /**
     * @param IRow $node
     * @throws ConnectException
     * @return bool
     */
    public function filterItems(IRow $node): bool
    {
        return is_null($this->filterByNamePart)
            || is_null($this->filterByColumn)
            || (
                $this->columnExists($node, $this->filterByColumn)
                && $this->compareValues($node, $this->filterByColumn, $this->filterByNamePart)
            );
    }

    protected function columnExists(IRow $node, string $whichColumn): bool
    {
        return $node->__isset($whichColumn);
    }

    /**
     * @param IRow $node
     * @param string $whichColumn
     * @param string|int $columnValue
     * @throws ConnectException
     * @return bool
     */
    protected function compareValues(IRow $node, string $whichColumn, $columnValue): bool
    {
        return false !== stripos(strval($node->getValue($whichColumn)), strval($columnValue));
    }

    /**
     * @param IRow $a
     * @param IRow $b
     * @throws ConnectException
     * @return int
     */
    public function sortItems(IRow $a, IRow $b)
    {
        return
            IOrder::ORDER_ASC == $this->orderDirection
                ? $a->getValue($this->orderColumn) <=> $b->getValue($this->orderColumn)
                : $b->getValue($this->orderColumn) <=> $a->getValue($this->orderColumn)
            ;
    }

    public function getFilterFactory(): IFilterFactory
    {
        return Filters\Factory::getInstance();
    }
}

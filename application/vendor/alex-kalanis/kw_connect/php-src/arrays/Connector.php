<?php

namespace kalanis\kw_connect\arrays;


use kalanis\kw_connect\core\AConnector;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IFilterFactory;
use kalanis\kw_connect\core\Interfaces\IFilterSubs;
use kalanis\kw_connect\core\Interfaces\IIterableConnector;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_connect\core\Interfaces\IRow;


/**
 * Class Connector
 * @package kalanis\kw_connect\arrays
 * For likes there is a column finder in search mapper.
 * So it's possible to map children for sorting and filtering.
 */
class Connector extends AConnector implements IIterableConnector
{
    /** @var string|int|null */
    protected $primaryKey = null;
    /** @var array<int|string, array<int|string, string|int|float|bool|null>> */
    protected $dataSource = [];
    /** @var array<int, array<string>> */
    protected $ordering = [];
    /** @var array<string|int|bool|Row> */
    protected $filteredData = [];
    /** @var string */
    protected $sortDirection = IOrder::ORDER_ASC;
    /** @var array<string|int> */
    protected $filtering = [];
    /** @var int|null */
    protected $offset = null;
    /** @var int|null */
    protected $limit = null;

    /**
     * @param array<int|string, array<int|string, string|int|float|bool|null>> $source
     * @param string|null $primaryKey
     */
    public function __construct(array $source, ?string $primaryKey = null)
    {
        $this->dataSource = $source;
        $this->primaryKey = $primaryKey;
    }

    /**
     * @param string $colName
     * @param string $filterType
     * @param string|int $value  cannot use array from range
     */
    public function setFiltering(string $colName, string $filterType, $value): void
    {
        $this->filtering[] = [$filterType, $colName, $value];
    }

    /**
     * @param array<IRow> $data
     * @return FilteringArrays
     */
    protected function getFiltered(&$data)
    {
        return new FilteringArrays($data);
    }

    /**
     * @param array<int|string, string|int|float|bool|null> $data
     * @return IRow
     */
    public function getTranslated($data): IRow
    {
        return new Row($data);
    }

    public function setOrdering(string $colName, string $direction): void
    {
        $this->ordering[] = [$colName, $direction];
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
     * @throws ConnectException
     */
    protected function parseData(): void
    {
        $translated = array_map([$this, 'getTranslated'], $this->dataSource);
        $filtered = $this->getFiltered($translated);
        foreach (array_reverse($this->filtering) as list($filterType, $columnName, $value)) {
            $type = $this->getFilterFactory()->getFilter($filterType);
            if ($type instanceof IFilterSubs) {
                $type->addFilterFactory($this->getFilterFactory());
            }
            $type->setDataSource($filtered);
            $type->setFiltering($columnName, $value);
            $filtered = $type->getDataSource();
        }

        foreach (array_reverse($this->ordering) as list($columnName, $direction)) {
            $toSort = $this->indexedArray($filtered, $columnName);
            if (IOrder::ORDER_ASC == $direction) {
                asort($toSort);
            } else {
                arsort($toSort);
            }
            $this->putItBack($filtered, $toSort);
        }

        $this->filteredData = $filtered->getArray();
        $this->translatedData = array_slice($filtered->getArray(), intval($this->offset), $this->limit);
        if (!empty($this->primaryKey)) {
            $translatedData = array_combine(array_map([$this, 'rowsPk'], $this->translatedData), $this->translatedData);
            if (false !== $translatedData) {
                $this->translatedData = $translatedData;
            }
        }
    }

    /**
     * @param IRow $row
     * @throws ConnectException
     * @return string
     */
    public function rowsPk(IRow $row): string
    {
        return strval($row->getValue($this->primaryKey));
    }

    /**
     * @param FilteringArrays $filtered
     * @param string $columnName
     * @throws ConnectException
     * @return array<string|int, int|string|float|bool|null>
     */
    protected function indexedArray(FilteringArrays $filtered, string $columnName): array
    {
        $result = [];
        foreach ($filtered->getArray() as $index => $item) {
            /** @var IRow $item */
            $result[$index] = $item->getValue($columnName);
        }
        return $result;
    }

    /**
     * @param FilteringArrays $filtered
     * @param array<string|int, int|string|float|bool|null> $sorted
     */
    protected function putItBack(FilteringArrays $filtered, array $sorted): void
    {
        $finalArray = [];
        foreach ($sorted as $key => $item) {
            $finalArray[$key] = $filtered->offsetGet($key);
        }
        $filtered->setArray($finalArray);
    }

    public function getFilterFactory(): IFilterFactory
    {
        return Filters\Factory::getInstance();
    }
}

<?php

namespace kalanis\kw_connect\core\Interfaces;


use kalanis\kw_connect\core\ConnectException;


/**
 * Interface IConnector
 * @package kalanis\kw_connect\Interfaces
 * Connect data source to table representation and work with it
 */
interface IConnector
{
    /**
     * @param string $colName
     * @param string $filterType
     * @param string|string[] $value
     * @throws ConnectException
     */
    public function setFiltering(string $colName, string $filterType, $value): void;

    /**
     * @param string $colName
     * @param string $direction
     * @throws ConnectException
     */
    public function setOrdering(string $colName, string $direction): void;

    /**
     * @param int|null $offset
     * @param int|null $limit
     * @throws ConnectException
     */
    public function setPagination(?int $offset, ?int $limit): void;

    /**
     * @throws ConnectException
     * @return int
     */
    public function getTotalCount(): int;

    /**
     * @throws ConnectException
     */
    public function fetchData(): void;

    /**
     * Get factory of types for current filter
     * @return IFilterFactory
     */
    public function getFilterFactory(): IFilterFactory;

    /**
     * Get cell content by preset key
     * @param string|int $key
     * @return mixed
     */
    public function getByKey($key);
}

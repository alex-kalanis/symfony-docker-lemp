<?php

namespace kalanis\kw_connect\core\Interfaces;


use kalanis\kw_connect\core\ConnectException;


/**
 * Interface IFilterType
 * @package kalanis\kw_connect\core\Interfaces
 * How the field affects search filter in datasource
 */
interface IFilterType
{
    const EMPTY_FILTER = '';

    /**
     * @param mixed $dataSource
     * @throws ConnectException
     * @return mixed
     */
    public function setDataSource($dataSource);

    /**
     * @throws ConnectException
     * @return mixed
     */
    public function getDataSource();

    /**
     * @param string $colName
     * @param mixed $value
     * @throws ConnectException
     * @return mixed
     */
    public function setFiltering(string $colName, $value);
}

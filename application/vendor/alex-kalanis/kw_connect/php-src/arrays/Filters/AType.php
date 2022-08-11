<?php

namespace kalanis\kw_connect\arrays\Filters;


use kalanis\kw_connect\arrays\FilteringArrays;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IFilterType;


/**
 * Class AType
 * @package kalanis\kw_connect\Filters\Arrays
 */
abstract class AType implements IFilterType
{
    /** @var FilteringArrays */
    protected $dataSource;

    /**
     * @param FilteringArrays $dataSource
     * @throws ConnectException
     * @return $this
     */
    public function setDataSource($dataSource)
    {
        if (!$dataSource instanceof FilteringArrays) {
            throw new ConnectException('Param $dataSource must be an instance of \kalanis\kw_table\arrays\FilteringArrays.');
        }

        $this->dataSource = $dataSource;
        return $this;
    }

    public function getDataSource()
    {
        return $this->dataSource;
    }
}

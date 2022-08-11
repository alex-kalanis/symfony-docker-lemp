<?php

namespace kalanis\kw_connect\nette\Filters;


use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IFilterType;
use Nette\Database\Table\Selection;


/**
 * Class AType
 * @package kalanis\kw_connect\nette\Filters
 */
abstract class AType implements IFilterType
{
    /** @var Selection */
    protected $netteTable;

    /**
     * @param Selection $dataSource
     * @throws ConnectException
     * @return $this
     */
    public function setDataSource($dataSource)
    {
        if (!$dataSource instanceof Selection) {
            throw new ConnectException('Param $dataSource must be an instance of \Nette\Database\Table\Selection.');
        }

        $this->netteTable = $dataSource;
        return $this;
    }

    public function getDataSource()
    {
        return $this->netteTable;
    }
}

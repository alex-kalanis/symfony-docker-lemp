<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


use Doctrine\DBAL\Query\QueryBuilder;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IFilterType;


/**
 * Class AType
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
abstract class AType implements IFilterType
{
    /** @var QueryBuilder */
    protected $queryBuilder;

    /**
     * @param QueryBuilder $dataSource
     * @throws ConnectException
     * @return $this
     */
    public function setDataSource($dataSource)
    {
        if (!$dataSource instanceof QueryBuilder) {
            throw new ConnectException('Param $dataSource must be an instance of \Doctrine\DBAL\Query\QueryBuilder.');
        }

        $this->queryBuilder = $dataSource;
        return $this;
    }

    public function getDataSource()
    {
        return $this->queryBuilder;
    }
}

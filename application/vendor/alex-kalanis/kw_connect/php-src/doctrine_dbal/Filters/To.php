<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


/**
 * Class To
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
class To extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->queryBuilder->where($this->queryBuilder->expr()->lt(
                $colName,
                $this->queryBuilder->createNamedParameter($value)
            ));
        }
        return $this;
    }
}

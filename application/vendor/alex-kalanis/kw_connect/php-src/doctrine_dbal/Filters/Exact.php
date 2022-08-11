<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


/**
 * Class Exact
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
class Exact extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->queryBuilder->where($this->queryBuilder->expr()->eq(
                $colName,
                $this->queryBuilder->createNamedParameter($value)
            ));
        }
        return $this;
    }
}

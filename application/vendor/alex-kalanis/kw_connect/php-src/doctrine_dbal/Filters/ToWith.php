<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


/**
 * Class ToWith
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
class ToWith extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->queryBuilder->where($this->queryBuilder->expr()->lte(
                $colName,
                $this->queryBuilder->createNamedParameter($value)
            ));
        }
        return $this;
    }
}

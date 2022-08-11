<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


/**
 * Class From
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
class From extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->queryBuilder->where($this->queryBuilder->expr()->gt(
                $colName,
                $this->queryBuilder->createNamedParameter($value)
            ));
        }
        return $this;
    }
}

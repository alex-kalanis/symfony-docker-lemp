<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


/**
 * Class Contains
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
class Contains extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->queryBuilder->where($this->queryBuilder->expr()->like(
                $colName,
                $this->queryBuilder->createNamedParameter($value)
            ));
        }
        return $this;
    }
}

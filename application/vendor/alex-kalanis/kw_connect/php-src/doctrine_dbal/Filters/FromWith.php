<?php

namespace kalanis\kw_connect\doctrine_dbal\Filters;


/**
 * Class FromWith
 * @package kalanis\kw_connect\doctrine_dbal\Filters
 */
class FromWith extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->queryBuilder->where($this->queryBuilder->expr()->gte(
                $colName,
                $this->queryBuilder->createNamedParameter($value)
            ));
        }
        return $this;
    }
}

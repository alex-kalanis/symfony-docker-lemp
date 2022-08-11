<?php

namespace kalanis\kw_connect\search\Filters;


/**
 * Class FromWith
 * @package kalanis\kw_connect\search\Filters
 */
class FromWith extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->search->from($colName, $value, true);
        }
        return $this;
    }
}

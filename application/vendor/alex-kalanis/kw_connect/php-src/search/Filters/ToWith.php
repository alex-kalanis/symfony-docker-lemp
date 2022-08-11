<?php

namespace kalanis\kw_connect\search\Filters;


/**
 * Class ToWith
 * @package kalanis\kw_connect\search\Filters
 */
class ToWith extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->search->to($colName, $value, true);
        }
        return $this;
    }
}

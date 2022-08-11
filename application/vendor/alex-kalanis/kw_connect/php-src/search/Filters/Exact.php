<?php

namespace kalanis\kw_connect\search\Filters;


/**
 * Class Exact
 * @package kalanis\kw_connect\search\Filters
 */
class Exact extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->search->exact($colName, $value);
        }
        return $this;
    }
}

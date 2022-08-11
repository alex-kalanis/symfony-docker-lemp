<?php

namespace kalanis\kw_connect\search\Filters;


/**
 * Class To
 * @package kalanis\kw_connect\search\Filters
 */
class To extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->search->to($colName, $value, false);
        }
        return $this;
    }
}

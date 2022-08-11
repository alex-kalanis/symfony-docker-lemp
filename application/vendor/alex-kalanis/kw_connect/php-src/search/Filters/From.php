<?php

namespace kalanis\kw_connect\search\Filters;


/**
 * Class From
 * @package kalanis\kw_connect\search\Filters
 */
class From extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->search->from($colName, $value, false);
        }
        return $this;
    }
}

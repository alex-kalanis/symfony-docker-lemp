<?php

namespace kalanis\kw_connect\search\Filters;


/**
 * Class Contains
 * @package kalanis\kw_connect\search\Filters
 */
class Contains extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->search->like($colName, $value);
        }
        return $this;
    }
}

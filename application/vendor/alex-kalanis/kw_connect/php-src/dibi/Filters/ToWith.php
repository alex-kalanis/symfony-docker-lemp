<?php

namespace kalanis\kw_connect\dibi\Filters;


/**
 * Class ToWith
 * @package kalanis\kw_connect\dibi\Filters
 */
class ToWith extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->dibiFluent->where($colName . ' <= ?', $value);
        }
        return $this;
    }
}

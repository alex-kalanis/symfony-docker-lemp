<?php

namespace kalanis\kw_connect\dibi\Filters;


/**
 * Class Exact
 * @package kalanis\kw_connect\dibi\Filters
 */
class Exact extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->dibiFluent->where($colName . ' = ?', $value);
        }
        return $this;
    }
}

<?php

namespace kalanis\kw_connect\dibi\Filters;


/**
 * Class FromWith
 * @package kalanis\kw_connect\dibi\Filters
 */
class FromWith extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->dibiFluent->where($colName . ' >= ?', $value);
        }
        return $this;
    }
}

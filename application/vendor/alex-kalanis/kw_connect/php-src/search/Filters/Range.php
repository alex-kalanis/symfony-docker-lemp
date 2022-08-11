<?php

namespace kalanis\kw_connect\search\Filters;


use kalanis\kw_connect\core\ConnectException;


/**
 * Class Range
 * @package kalanis\kw_connect\search\Filters
 */
class Range extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if (!is_array($value) || empty($value) || !isset($value[0]) || !isset($value[1])) {
            throw new ConnectException('Value must be an array of two values with keys 0 and 1.');
        }

        if (!empty($value[0])) {
            $this->search->from($colName, $value[0]);
        }
        if (!empty($value[1])) {
            $this->search->to($colName, $value[1]);
        }

        return $this;
    }
}

<?php

namespace kalanis\kw_connect\nette\Filters;


/**
 * Class From
 * @package kalanis\kw_connect\nette\Filters
 */
class From extends AType
{
    public function setFiltering(string $colName, $value)
    {
        if ('' !== $value) {
            $this->netteTable->where($colName . ' > ?', $value);
        }
        return $this;
    }
}

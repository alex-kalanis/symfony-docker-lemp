<?php

namespace kalanis\kw_connect\arrays\Filters;


use kalanis\kw_connect\core\Interfaces\IRow;


/**
 * Class ToWith
 * @package kalanis\kw_connect\core\Filters\Arrays
 */
class ToWith extends AType
{
    /**
     * @param string           $colName
     * @param string|int|float $value
     * @return $this
     */
    public function setFiltering($colName, $value)
    {
        $this->dataSource->setArray(array_filter($this->dataSource->getArray(), function (IRow $item) use ($colName, $value) {
            return $item->getValue($colName) <= $value;
        }));
        return $this;
    }
}

<?php

namespace kalanis\kw_connect\arrays;


use kalanis\kw_connect\core\Interfaces\IRow;


/**
 * Class Row
 * @package kalanis\kw_connect\arrays
 */
class Row implements IRow
{
    /** @var array<int|string, int|string|float|bool|null> */
    protected $array;

    /**
     * @param array<int|string, int|string|float|bool|null> $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function getValue($property)
    {
        return $this->array[$property];
    }

    public function __isset($name)
    {
        return isset($this->array[$name]);
    }
}

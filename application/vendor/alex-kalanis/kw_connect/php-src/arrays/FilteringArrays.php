<?php

namespace kalanis\kw_connect\arrays;


use ArrayAccess;
use Countable;


/**
 * Class FilteringArrays
 * @package kalanis\kw_connect\arrays
 * Class for updating arrays via reference
 */
class FilteringArrays implements ArrayAccess, Countable
{
    /**
     * @var array<string|int, string|int|float|bool|null|Row>
     */
    protected $array;

    /**
     * @param array<string|int, string|int|float|bool|null|Row> $array
     */
    public function __construct(array &$array)
    {
        $this->array = &$array;
    }

    /**
     * @return array<string|int, string|int|float|bool|null|Row>
     */
    public function &getArray()
    {
        return $this->array;
    }

    /**
     * @param array<string|int, string|int|float|bool|null|Row> $array
     * @return $this
     */
    public function setArray($array): self
    {
        $this->array = $array;
        return $this;
    }

    public function resetArray(): self
    {
        $this->array = [];
        return $this;
    }

    /**
     * @param string|int $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    /**
     * @param string|int $offset
     * @return string|int|float|bool|null|Row
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->array[$offset] : null ;
    }

    /**
     * @param string|int $offset
     * @param string|int|float|bool|null|Row $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->array[$offset] = $value;
    }

    /**
     * @param string|int $offset
     */
    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->array[$offset]);
        }
    }

    public function count(): int
    {
        return count($this->array);
    }
}

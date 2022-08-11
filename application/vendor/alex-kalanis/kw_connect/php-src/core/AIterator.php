<?php

namespace kalanis\kw_connect\core;


/**
 * Class AIterator
 * @package kalanis\kw_connect\core
 * Iterate over specific inner variable
 */
abstract class AIterator implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * Iterable variable
     * @var array<string|int, string|int|float|bool|null>
     */
    protected $iterable = [];

    /**
     * Name of iterable variable;
     * @return string
     */
    abstract protected function getIterableName(): string;

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->{$this->getIterableName()});
    }

    public function offsetExists($offset): bool
    {
        return isset($this->{$this->getIterableName()}[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->{$this->getIterableName()}[$offset] : null ;
    }

    public function offsetSet($offset, $value): void
    {
        $this->{$this->getIterableName()}[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->{$this->getIterableName()}[$offset]);
        }
    }

    public function count(): int
    {
        return count($this->{$this->getIterableName()});
    }
}

<?php

namespace kalanis\kw_input;


use ArrayAccess, IteratorAggregate, Traversable, Countable, ArrayIterator;
use kalanis\kw_input\Entries\Entry;


/**
 * Class Input
 * @package kalanis\kw_input
 * Abstraction of inputs - this is access which can be implemented without the whole bloat of kw_input
 * but still passed into processing libraries
 */
class Input implements ArrayAccess, IteratorAggregate, Countable
{
    /** @var Interfaces\IEntry[] */
    protected $inputs = [];

    /**
     * @param Interfaces\IEntry[] $inputs
     */
    public function __construct(array $inputs)
    {
        $this->inputs = &$inputs;
    }

    /**
     * @param string|int $offset
     * @return Interfaces\IEntry|string|float|int|bool|null
     */
    public final function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @param string|int $offset
     * @param Interfaces\IEntry|string|float|int|bool $value
     * @return void
     */
    public final function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * @param string|int $offset
     * @return bool
     */
    public final function __isset($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * @param string|int $offset
     * @return void
     */
    public final function __unset($offset)
    {
        $this->offsetUnset($offset);
    }

    /**
     * Implementing ArrayAccess
     * @param string|int $offset
     * @param Interfaces\IEntry|string|float|int|bool $value
     */
    public final function offsetSet($offset, $value): void
    {
        if ($this->offsetExists($offset)) {
            $source = $this->offsetGet($offset);
            $source = $source ?: Interfaces\IEntry::SOURCE_EXTERNAL;
            $entry = new Entry();
            $entry->setEntry(strval($source), strval($offset), $value);
            $this->inputs[strval($offset)] = $entry;
        } elseif ($value instanceof Interfaces\IEntry) {
            $this->inputs[$value->getKey()] = $value;
        } else {
            $entry = new Entry();
            $entry->setEntry(Interfaces\IEntry::SOURCE_EXTERNAL, strval($offset), $value);
            $this->inputs[strval($offset)] = $entry;
        }
    }

    /**
     * Implementing ArrayAccess
     * @param string|int $offset
     * @return bool
     */
    public final function offsetExists($offset): bool
    {
        return isset($this->inputs[$offset]);
    }

    /**
     * Implementing ArrayAccess
     * @param string|int $offset
     */
    public final function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->inputs[$offset]);
        }
    }

    /**
     * Implementing ArrayAccess
     * @param string|int $offset
     * @return Interfaces\IEntry|null
     */
    #[\ReturnTypeWillChange]
    public final function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->inputs[$offset] : null;
    }

    /**
     * Implementing IteratorAggregate
     * Return all inputs as array iterator
     * @return Traversable<string|int, Interfaces\IEntry>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->inputs);
    }

    /**
     * Implementing Countable
     * @return int
     */
    public final function count(): int
    {
        return count($this->inputs);
    }
}
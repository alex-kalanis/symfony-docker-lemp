<?php

namespace kalanis\kw_forms\Adapters;


use ArrayAccess;
use Countable;
use Iterator;
use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_input\Interfaces\IEntry;


abstract class AAdapter implements ArrayAccess, Countable, Iterator, IEntry
{
    /** @var string|null */
    protected $key = null;
    /** @var array<string, string|int|float|null|IEntry> */
    protected $vars = [];

    /**
     * @param string $inputType
     * @throws FormsException
     */
    abstract public function loadEntries(string $inputType): void;

    public function getKey(): string
    {
        return strval($this->key);
    }

    /**
     * @return mixed|string|null
     */
    public function getValue()
    {
        return $this->current();
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->valid() ? $this->offsetGet($this->key) : null ;
    }

    public function next(): void
    {
        next($this->vars);
        $this->key = key($this->vars);
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->key;
    }

    public function valid(): bool
    {
        return $this->offsetExists($this->key);
    }

    public function rewind(): void
    {
        reset($this->vars);
        $this->key = key($this->vars);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->vars[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->vars[$offset];
    }

    /**
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->vars[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->vars[$offset]);
    }

    public function count(): int
    {
        return count($this->vars);
    }

    protected function removeNullBytes(string $string, string $nullTo = ''): string
    {
        return strval(str_replace(chr(0), $nullTo, $string));
    }
}

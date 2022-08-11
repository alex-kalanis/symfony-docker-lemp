<?php

namespace kalanis\kw_address_handler;


use ArrayAccess;


/**
 * Class Params
 * @package kalanis\kw_address_handler\Sources
 * Class for accessing params inside the address as array
 * Not ArrayIterator due memory consumption
 */
class Params implements ArrayAccess
{
    /** @var array<string|int, string> */
    protected $paramsData = [];

    /**
     * @param array<string|int, string> $data
     * @return $this
     */
    public function setParamsData(array $data): self
    {
        $this->paramsData = $data;
        return $this;
    }

    /**
     * @return array<string|int, string>
     */
    public function getParamsData(): array
    {
        return $this->paramsData;
    }

    /**
     * @param string|int $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->paramsData[$offset]);
    }

    /**
     * @param string|int $offset
     * @return string|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->paramsData[$offset] : null;
    }

    /**
     * @param string|int $offset
     * @param string $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->paramsData[$offset] = strval($value);
    }

    /**
     * @param string|int $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->paramsData[$offset]);
    }
}

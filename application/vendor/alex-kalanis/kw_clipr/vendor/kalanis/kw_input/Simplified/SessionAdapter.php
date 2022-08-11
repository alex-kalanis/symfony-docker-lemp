<?php

namespace kalanis\kw_input\Simplified;


use ArrayAccess;


/**
 * Class SessionAdapter
 * @package kalanis\kw_input\Extras
 * Accessing _SESSION via ArrayAccess
 */
class SessionAdapter implements ArrayAccess
{
    use TNullBytes;

    /**
     * @param string|int $offset
     * @return mixed
     */
    public final function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @param string|int $offset
     * @param mixed|null $value
     */
    public final function __set($offset, $value): void
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * @param string|int $offset
     * @return bool
     */
    public final function __isset($offset): bool
    {
        return $this->offsetExists($offset);
    }

    /**
     * @param string|int $offset
     */
    public final function __unset($offset): void
    {
        $this->offsetUnset($offset);
    }

    public final function offsetExists($offset): bool
    {
        return isset($_SESSION[$this->removeNullBytes(strval($offset))]);
    }

    #[\ReturnTypeWillChange]
    public final function offsetGet($offset)
    {
        return $_SESSION[$this->removeNullBytes(strval($offset))];
    }

    public final function offsetSet($offset, $value): void
    {
        $_SESSION[$this->removeNullBytes(strval($offset))] = $value;
    }

    public final function offsetUnset($offset): void
    {
        unset($_SESSION[$this->removeNullBytes(strval($offset))]);
    }
}

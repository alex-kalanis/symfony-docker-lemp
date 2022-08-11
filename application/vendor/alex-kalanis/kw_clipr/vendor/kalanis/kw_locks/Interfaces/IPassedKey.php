<?php

namespace kalanis\kw_locks\Interfaces;


use kalanis\kw_locks\LockException;


/**
 * Interface IPassedKey
 * @package kalanis\kw_locks\Interfaces
 * Pass key to lock
 */
interface IPassedKey extends ILock
{
    /**
     * Set key extra
     * @param string $key
     * @throws LockException
     */
    public function setKey(string $key): void;
}

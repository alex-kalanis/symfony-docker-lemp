<?php

namespace kalanis\kw_locks\Interfaces;


use kalanis\kw_locks\LockException;


/**
 * Interface ILock
 * @package kalanis\kw_locks\Interfaces
 * Basic lock properties
 */
interface ILock
{
    const LOCK_FILE = '.lock'; # lock file ext

    /**
     * Already has lock
     * @throws LockException
     * @return bool
     */
    public function has(): bool;

    /**
     * Create new one
     * @param bool $force forced creation
     * @throws LockException
     * @return bool
     */
    public function create(bool $force = false): bool;

    /**
     * Remove current one
     * @param bool $force forced removal
     * @throws LockException
     * @return bool
     */
    public function delete(bool $force = false): bool;
}

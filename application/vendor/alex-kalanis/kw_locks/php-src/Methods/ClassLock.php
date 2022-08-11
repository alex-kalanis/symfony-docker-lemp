<?php

namespace kalanis\kw_locks\Methods;


use kalanis\kw_locks\Interfaces\ILock;
use kalanis\kw_locks\Interfaces\IPassedKey;
use kalanis\kw_locks\LockException;


/**
 * Class ClassLock
 * @package kalanis\kw_locks\Methods
 * Lock target which is represented by class
 */
class ClassLock implements ILock
{
    /** @var string */
    protected $lockFilename = '';
    /** @var IPassedKey */
    protected $parentClass = null;

    public function __construct(IPassedKey $parentClass)
    {
        $this->parentClass = $parentClass;
    }

    /**
     * @param object $lockedClass
     * @throws LockException
     */
    public function setClass(object $lockedClass): void
    {
        $this->parentClass->setKey(strval(str_replace('/', ':', get_class($lockedClass)) . ILock::LOCK_FILE));
    }

    public function has(): bool
    {
        return $this->parentClass->has();
    }

    public function create(bool $force = false): bool
    {
        return $this->parentClass->create($force);
    }

    public function delete(bool $force = false): bool
    {
        return $this->parentClass->delete($force);
    }
}

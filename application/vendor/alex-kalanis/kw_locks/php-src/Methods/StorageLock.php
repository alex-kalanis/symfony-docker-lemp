<?php

namespace kalanis\kw_locks\Methods;


use kalanis\kw_locks\Interfaces\IKLTranslations;
use kalanis\kw_locks\Interfaces\IPassedKey;
use kalanis\kw_locks\LockException;
use kalanis\kw_storage\Storage;
use kalanis\kw_storage\StorageException;


/**
 * Class StorageLock
 * @package kalanis\kw_locks\Methods
 */
class StorageLock implements IPassedKey
{
    /** @var Storage */
    protected $storage = null;
    /** @var IKLTranslations */
    protected $lang = null;
    /** @var string */
    protected $specialKey = '';
    /** @var string */
    protected $checkContent = '';

    public function __construct(Storage $storage, ?IKLTranslations $lang = null)
    {
        $this->storage = $storage;
        $this->lang = $lang ?: new Translations();
    }

    public function __destruct()
    {
        try {
            $this->delete();
        } catch (LockException $ex) {
            // do nothing instead of
            // register_shutdown_function([$this, 'delete']);
        }
    }

    public function setKey(string $key, string $checkContent = ''): void
    {
        $this->specialKey = $key;
        $this->checkContent = empty($checkContent) ? strval(getmypid()) : $checkContent ;
    }

    public function has(): bool
    {
        try {
            if (!$this->storage->exists($this->specialKey)) {
                return false;
            }
            if ($this->checkContent == strval($this->storage->get($this->specialKey))) {
                return true;
            }
            throw new LockException($this->lang->iklLockedByOther());
        } catch (StorageException $ex) {
            throw new LockException($this->lang->iklProblemWithStorage(), 0, $ex);
        }
    }

    public function create(bool $force = false): bool
    {
        if (!$force && $this->has()) {
            return false;
        }
        try {
            $result = $this->storage->set($this->specialKey, $this->checkContent);
            return $result;
        } catch (StorageException $ex) {
            throw new LockException($this->lang->iklProblemWithStorage(), 0, $ex);
        }
    }

    public function delete(bool $force = false): bool
    {
        if (!$force && !$this->has()) {
            return true;
        }
        try {
            return $this->storage->delete($this->specialKey);
        } catch (StorageException $ex) {
            throw new LockException($this->lang->iklProblemWithStorage(), 0, $ex);
        }
    }
}

<?php

namespace kalanis\kw_storage\Storage;


use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Interfaces;


/**
 * Class Storage
 * @package kalanis\kw_storage\Storage
 * Main connection through storage structure
 */
class Storage
{
    /** @var Interfaces\IStorage */
    protected $storage = null;
    /** @var Interfaces\IFormat */
    protected $format = null;
    /** @var Interfaces\IKey */
    protected $key = null;

    public function __construct(Interfaces\IStorage $storage, Interfaces\IFormat $format, Interfaces\IKey $key)
    {
        $this->storage = $storage;
        $this->format = $format;
        $this->key = $key;
    }

    /**
     * Check if storage is usable
     * @return bool
     */
    public function canUse(): bool
    {
        return $this->storage->check($this->key->fromSharedKey(''));
    }

    /**
     * Create new record in storage
     * @param string $sharedKey
     * @param mixed $data
     * @param int|null $timeout
     * @throws StorageException
     * @return bool
     */
    public function write(string $sharedKey, $data, ?int $timeout = null): bool
    {
        return $this->storage->save($this->key->fromSharedKey($sharedKey), $this->format->encode($data), $timeout);
    }

    /**
     * Read storage record
     * @param string $sharedKey
     * @throws StorageException
     * @return mixed
     */
    public function read(string $sharedKey)
    {
        return $this->format->decode($this->storage->load($this->key->fromSharedKey($sharedKey)));
    }

    /**
     * Delete storage record - usually on finish or discard
     * @param string $sharedKey
     * @throws StorageException
     * @return bool
     */
    public function remove(string $sharedKey): bool
    {
        return $this->storage->remove($this->key->fromSharedKey($sharedKey));
    }

    /**
     * Has data in storage? Mainly for testing
     * @param string $sharedKey
     * @return bool
     */
    public function exists(string $sharedKey): bool
    {
        return $this->storage->exists($this->key->fromSharedKey($sharedKey));
    }

    /**
     * What data is in storage?
     * @param string $mask
     * @throws StorageException
     * @return string[]
     */
    public function lookup(string $mask): iterable
    {
        return $this->storage->lookup($this->key->fromSharedKey($mask));
    }

    /**
     * Increment index in key
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function increment(string $key): bool
    {
        return $this->storage->increment($this->key->fromSharedKey($key));
    }

    /**
     * Decrement index in key
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function decrement(string $key): bool
    {
        return $this->storage->decrement($this->key->fromSharedKey($key));
    }

    /**
     * Remove multiple keys
     * @param string[] $keys
     * @throws StorageException
     * @return array<int|string, bool>
     */
    public function removeMulti(array $keys): array
    {
        return $this->storage->removeMulti(array_map([$this, 'multiKey'], $keys));
    }

    protected function multiKey(string $key): string
    {
        return $this->key->fromSharedKey($key);
    }
}

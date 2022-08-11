<?php

namespace kalanis\kw_storage;


/**
 * Class StaticCache
 * @package kalanis\kw_storage
 * Static face for caching values in selected storage
 * @codeCoverageIgnore because it's only syntactic sugar
 */
class StaticCache
{
    /** @var Storage|null */
    protected static $storage = null;

    public static function setStorage(?Storage $storage = null): void
    {
        static::$storage = $storage;
    }

    public static function getStorage(): ?Storage
    {
        return static::$storage;
    }

    /**
     * Get data from storage
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        try {
            static::checkStorage();
            return static::$storage->get($key);
        } catch (StorageException $ex) {
            return [];
        }
    }

    /**
     * Set data to storage
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return boolean
     */
    public static function set(string $key, $value, ?int $expire = 8600): bool
    {
        try {
            static::checkStorage();
            return static::$storage->set($key, $value, $expire);
        } catch (StorageException $ex) {
            return false;
        }
    }

    /**
     * Add data to storage
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return boolean
     */
    public static function add(string $key, $value, ?int $expire = 8600): bool
    {
        try {
            static::checkStorage();
            return static::$storage->add($key, $value, $expire);
        } catch (StorageException $ex) {
            return false;
        }
    }

    /**
     * Increment value by key
     * @param string $key
     * @return boolean
     */
    public static function increment(string $key): bool
    {
        try {
            static::checkStorage();
            return static::$storage->increment($key);
        } catch (StorageException $ex) {
            return false;
        }
    }

    /**
     * Decrement value by key
     * @param string $key
     * @return boolean
     */
    static public function decrement(string $key): bool
    {
        try {
            static::checkStorage();
            return static::$storage->decrement($key);
        } catch (StorageException $ex) {
            return false;
        }
    }

    /**
     * Return all active storage keys
     * @return string[]
     */
    public static function getAllKeys(): iterable
    {
        try {
            static::checkStorage();
            return static::$storage->getAllKeys();
        } catch (StorageException $ex) {
            yield from [];
        }
    }

    /**
     * Delete data by key from storage
     * @param string $key
     * @return boolean
     */
    public static function delete(string $key): bool
    {
        try {
            static::checkStorage();
            return static::$storage->delete($key);
        } catch (StorageException $ex) {
            return false;
        }
    }

    /**
     * Delete multiple keys from storage
     * @param string[] $keys
     * @return array<int|string, bool>
     */
    public static function deleteMulti(array $keys)
    {
        try {
            static::checkStorage();
            return static::$storage->deleteMulti($keys);
        } catch (StorageException $ex) {
            return [];
        }
    }

    /**
     * Delete all data from storage where key starts with prefix
     * @param string $prefix
     * @param boolean $inverse - if true remove all data where keys doesn't starts with prefix
     */
    public static function deleteByPrefix(string $prefix, $inverse = false): void
    {
        try {
            static::checkStorage();
            static::$storage->deleteByPrefix($prefix, $inverse);
        } catch (StorageException $ex) {
        }
    }

    /**
     * Check connection status to storage
     * @return boolean
     */
    public static function isConnected(): bool
    {
        try {
            static::checkStorage();
            return static::$storage->isConnected();
        } catch (StorageException $ex) {
            return false;
        }
    }

    /**
     * @throws StorageException
     */
    protected static function checkStorage(): void
    {
        if (empty(static::$storage)) {
            throw new StorageException('Storage not initialized');
        }
    }
}

<?php

namespace kalanis\kw_storage\Interfaces;


use kalanis\kw_storage\StorageException;
use Traversable;


interface IStorage
{
    /**
     * @param string $key
     * @return bool
     */
    public function check(string $key): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return string
     */
    public function load(string $key);

    /**
     * @param string $key
     * @param mixed $data
     * @param int|null $timeout
     * @throws StorageException
     * @return bool
     */
    public function save(string $key, $data, ?int $timeout = null): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function remove(string $key): bool;

    /**
     * Lookup through keys in storage
     * @param string $key
     * @throws StorageException
     * @return string[]
     */
    public function lookup(string $key): iterable;

    /**
     * Increment index in key
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function increment(string $key): bool;

    /**
     * Decrement index in key
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function decrement(string $key): bool;

    /**
     * Remove multiple keys
     * @param string[] $keys
     * @throws StorageException
     * @return array<int|string, bool>
     */
    public function removeMulti(array $keys): array;
}

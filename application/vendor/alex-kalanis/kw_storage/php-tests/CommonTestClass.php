<?php

use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage;


class CommonTestClass extends \PHPUnit\Framework\TestCase
{
    protected function getTestDir(): string
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'tmp']) . DIRECTORY_SEPARATOR;
    }

    protected function mockTestFile(): string
    {
        return $this->getTestDir() . 'testingFile.txt';
    }
}


class TargetMock implements \kalanis\kw_storage\Interfaces\IStorage
{
    public function check(string $key): bool
    {
        return true;
    }

    public function exists(string $key): bool
    {
        return false;
    }

    public function load(string $key)
    {
        return 'dummy mock';
    }

    public function save(string $key, $data, ?int $timeout = null): bool
    {
        return empty($timeout);
    }

    public function remove(string $key): bool
    {
        return false;
    }

    public function lookup(string $key): iterable
    {
        yield from [];
    }

    public function increment(string $key): bool
    {
        return true;
    }

    public function decrement(string $key): bool
    {
        return false;
    }

    public function removeMulti(array $keys): array
    {
        return [];
    }
}


class MockKey implements \kalanis\kw_storage\Interfaces\IKey
{
    public function fromSharedKey(string $key): string
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'tmp', $key]);
    }
}


class MockKeyFactory extends Storage\Key\Factory
{
    public function getKey(Interfaces\IStorage $storage): Interfaces\IKey
    {
        return new MockKey();
    }
}


class MockFormatFactory extends Storage\Format\Factory
{
    public function getFormat(Interfaces\IStorage $storage): Interfaces\IFormat
    {
        return new Storage\Format\Raw();
    }
}


class MockTargetFactory extends Storage\Target\Factory
{
    public function getStorage($params): Interfaces\IStorage
    {
        return new \TargetMock();
    }
}

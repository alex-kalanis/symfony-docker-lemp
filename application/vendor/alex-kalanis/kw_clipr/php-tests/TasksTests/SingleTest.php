<?php

namespace TasksTests;


use CommonTestClass;
use kalanis\kw_clipr\CliprException;
use kalanis\kw_clipr\Output;
use kalanis\kw_clipr\Tasks\ASingleTask;
use kalanis\kw_clipr\Loaders\KwLoader;
use kalanis\kw_input\Filtered\EntryArrays;
use kalanis\kw_locks\Interfaces\ILock;
use kalanis\kw_locks\Interfaces\IPassedKey;
use kalanis\kw_locks\LockException;


class SingleTest extends CommonTestClass
{
    /**
     * @throws LockException
     */
    public function testStartup(): void
    {
        $this->assertNotEmpty(new XSingle());
    }

    /**
     * @throws LockException
     */
    public function testStartupPass(): void
    {
        $this->assertNotEmpty(new XSingle(new XPLock()));
    }

    /**
     * @throws LockException
     */
    public function testStartupClass(): void
    {
        $this->assertNotEmpty(new XSingle(new XSLock()));
    }

    /**
     * @throws LockException
     */
    public function testNormal(): void
    {
        $lock = new XLock();
        $lock->delete();
        $lib = new XSingle($lock);
        $lib->initTask(new Output\Clear(), new EntryArrays($this->getParams()), new KwLoader());
        $this->assertNotEmpty($lib);
    }

    /**
     * @throws LockException
     */
    public function testLocked(): void
    {
        $lock = new XLock();
        // first run
        $lib1 = new XSingle($lock);
        $lib1->initTask(new Output\Clear(), new EntryArrays($this->getParams()), new KwLoader());

        // second run
        $lib2 = new XSingle($lock);
        $this->expectException(CliprException::class);
        $lib2->initTask(new Output\Clear(), new EntryArrays($this->getParams()), new KwLoader());
    }

    /**
     * @throws LockException
     */
    public function testFailLockCreation(): void
    {
        $lock = new XCLock();
        $lib = new XSingle($lock);
        $lib->initTask(new Output\Clear(), new EntryArrays($this->getParams()), new KwLoader());
        $this->assertNotEmpty($lib);
    }

    /**
     * @throws LockException
     */
    public function testFailLockRemoval(): void
    {
        $lock = new XDLock();
        $lib = new XSingle($lock);
        $this->expectException(CliprException::class); // fail with locks - cannot create and delete
        $lib->initTask(new Output\Clear(), new EntryArrays($this->getParams()), new KwLoader());
    }

    protected function getParams(): array
    {
        return [
            's' => $this->initEntry('s', 's', true),
        ];
    }
}


class XSingle extends ASingleTask
{
    /**
     * @throws LockException
     */
    public function clear(): void
    {
        $this->lock->delete(true);
    }

    /**
     * @param string $key
     * @throws LockException
     */
    public function setDummyKey(string $key): void
    {
        if ($this->lock instanceof IPassedKey) {
            $this->lock->setKey($key);
        }
    }

    public function desc(): string
    {
        return 'Testing single task';
    }

    public function process(): void
    {
        // nothing need
    }

    public function writeLn(/** @scrutinizer ignore-unused */ string $output = ''): void
    {
        // nothing!
    }
}


class XLock implements ILock
{
    protected $dummyLock = false;

    public function has(): bool
    {
        return $this->dummyLock;
    }

    public function create(bool $force = false): bool
    {
        $this->dummyLock = true;
        return true;
    }

    public function delete(bool $force = false): bool
    {
        $this->dummyLock = false;
        return true;
    }
}


class XPLock extends XLock implements IPassedKey
{
    public function setKey(string $key): void
    {
    }
}


class XSLock extends XLock
{
    public function setClass(/** @scrutinizer ignore-unused */ object $class): void
    {
    }
}


class XCLock extends XLock
{
    public function create(bool $force = false): bool
    {
        throw new LockException('fail to create');
    }
}


class XDLock extends XCLock
{
    public function delete(bool $force = false): bool
    {
        throw new LockException('fail to remove');
    }
}

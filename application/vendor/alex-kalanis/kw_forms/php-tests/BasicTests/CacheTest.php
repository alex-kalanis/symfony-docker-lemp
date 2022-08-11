<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_forms\Cache\Storage;


class CacheTest extends CommonTestClass
{
    public function testStorageTrait(): void
    {
        $storagePart = new \StorageTrait();
        $storagePart->deleteStored();
        $this->assertFalse($storagePart->isStored());
        $storagePart->setStorage(new \StorageMock());
        $storagePart->deleteStored();
        $this->assertFalse($storagePart->isStored());
    }

    public function testStorage(): void
    {
        $storage = new Storage(new \StorageMock());
        $storage->setAlias('test');
        $storage->store($this->contentStructure());
        $this->assertTrue($storage->isStored());
        $data = $storage->load();
        $this->assertNotEmpty($data);
        $storage->delete();
        $this->assertFalse($storage->isStored());
    }

    public function testStorageNothing(): void
    {
        $storage = new Storage();
        $storage->setAlias('test');
        $storage->store($this->contentStructure());
        $this->assertFalse($storage->isStored());
        $data = $storage->load();
        $this->assertEmpty($data);
        $storage->delete();
        $this->assertFalse($storage->isStored());
    }

    public function testStorageFailedData(): void
    {
        $mock = new \StorageMock();
        $storage = new Storage($mock);
        $storage->setAlias('test');
        $storage->store($this->contentStructure());
        $this->assertTrue($storage->isStored());
        $mock->save('FormStorage_test_', '----'); // boo!
        $data = $storage->load();
        $this->assertEmpty($data);
        $storage->delete();
        $this->assertFalse($storage->isStored());
    }

    protected function contentStructure()
    {
        return ['6g8a7' => 'dfh4dg364sd6g', 'hzsdfgh' => 35.4534, 'sfkg' => false, 'hdhg' => 'sdfh5433'];
    }
}

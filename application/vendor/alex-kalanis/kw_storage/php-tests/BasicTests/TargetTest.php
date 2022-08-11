<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Storage;
use kalanis\kw_storage\StorageException;


class TargetTest extends CommonTestClass
{
    /**
     * @throws StorageException
     */
    public function testInit(): void
    {
        $factory = new Storage\Factory(new Storage\Target\Factory(), new \MockFormatFactory(), new \MockKeyFactory());
        $this->assertEmpty($factory->getStorage('none'));
    }

    public function testVolumeDir(): void
    {
        $volume = $this->getStorageVolume();
        // test file
        $this->assertTrue($volume->canUse());
        $this->assertFalse($volume->exists('dummyFile.tst'));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileOperations(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->write('dummyFile.tst', 'asdfghjklpoiuztrewqyxcvbnm'));
        $this->assertEquals('dummy mock', $volume->read('dummyFile.tst'));
        $this->assertFalse($volume->remove('dummyFile.tst'));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileLookup(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertEmpty(iterator_to_array($volume->lookup('dummyFile')));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileCounter(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->increment('dummyFile.tst'));
        $this->assertFalse($volume->decrement('dummyFile.tst'));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileHarderCounter(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertEmpty($volume->removeMulti(['dummyFile.tst']));
    }

    protected function getStorageVolume(): Storage\Storage
    {
        return $this->getStorageFactory()->getStorage(null);
    }

    protected function getStorageFactory(): Storage\Factory
    {
        return new Storage\Factory(new \MockTargetFactory(), new \MockFormatFactory(), new \MockKeyFactory());
    }
}

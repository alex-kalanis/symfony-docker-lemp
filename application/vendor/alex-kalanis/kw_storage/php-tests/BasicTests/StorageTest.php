<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Storage\Target;
use kalanis\kw_storage\StorageException;


class StorageTest extends CommonTestClass
{
    public function tearDown(): void
    {
        if (is_file($this->mockTestFile())) {
            unlink($this->mockTestFile());
        }
        if (is_dir($this->mockTestFile())) {
            rmdir($this->mockTestFile());
        }
        parent::tearDown();
    }

    public function testInit(): void
    {
        $factory = new Target\Factory();
        $this->assertInstanceOf('\TargetMock', $factory->getStorage(new \TargetMock()));
        $this->assertEmpty($factory->getStorage([]));
        $this->assertInstanceOf('\kalanis\kw_storage\Storage\Target\Volume', $factory->getStorage(['storage' => 'volume']));
        $this->assertEmpty($factory->getStorage(['storage' => 'none']));
        $this->assertInstanceOf('\kalanis\kw_storage\Storage\Target\Volume', $factory->getStorage('volume'));
        $this->assertEmpty($factory->getStorage('none'));
        $this->assertEmpty($factory->getStorage('what'));
        $this->assertEmpty($factory->getStorage(null));
    }

    public function testVolumeDir(): void
    {
        $volume = new Target\Volume();

        // test dir
        $testDir = $this->getTestDir();
        $mockPath = substr($testDir, 0, strrpos($testDir, DIRECTORY_SEPARATOR)) . 'dummy';
        if (is_dir($mockPath)) {
            rmdir($mockPath);
        }
        file_put_contents($mockPath, 'just leave it there');
        $this->assertTrue($volume->check($mockPath . DIRECTORY_SEPARATOR));
        rmdir($mockPath);
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileExists(): void
    {
        $volume = new Target\Volume();
        $this->assertTrue($volume->check($this->getTestDir()));
        $this->assertFalse($volume->exists($this->mockTestFile()));
        $this->expectException(StorageException::class);
        $volume->load($this->mockTestFile());
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileOperations(): void
    {
        $volume = new Target\Volume();
        $this->assertFalse($volume->exists($this->mockTestFile()));
        $this->assertTrue($volume->save($this->mockTestFile(), 'asdfghjklpoiuztrewqyxcvbnm'));
        $this->assertTrue($volume->exists($this->mockTestFile()));
        $this->assertEquals('asdfghjklpoiuztrewqyxcvbnm', $volume->load($this->mockTestFile()));
        $this->assertTrue($volume->remove($this->mockTestFile()));
        $this->assertFalse($volume->exists($this->mockTestFile()));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileLookup(): void
    {
        $volume = new Target\Volume();
        $this->assertTrue($volume->check($this->getTestDir()));
        $testFiles = [
            'dummyFile.tst' => $this->getTestDir() . 'dummyFile.tst',
            'dummyFile.0.tst' => $this->getTestDir() . 'dummyFile.0.tst',
            'dummyFile.1.tst' => $this->getTestDir() . 'dummyFile.1.tst',
            'dummyFile.2.tst' => $this->getTestDir() . 'dummyFile.2.tst',
        ];
        $removal = $volume->removeMulti($testFiles);
        $this->assertEquals([
            'dummyFile.tst' => false,
            'dummyFile.0.tst' => false,
            'dummyFile.1.tst' => false,
            'dummyFile.2.tst' => false,
        ], $removal);

        iterator_to_array($volume->lookup('this path does not exists'));
        $this->assertEquals(0, count(iterator_to_array($volume->lookup($this->getTestDir()))));

        file_put_contents($this->getTestDir() . 'dummyFile.tst', 'asdfghjklqwertzuiopyxcvbnm');
        file_put_contents($this->getTestDir() . 'dummyFile.0.tst', 'asdfghjklqwertzuiopyxcvbnm');
        file_put_contents($this->getTestDir() . 'dummyFile.1.tst', 'asdfghjklqwertzuiopyxcvbnm');
        file_put_contents($this->getTestDir() . 'dummyFile.2.tst', 'asdfghjklqwertzuiopyxcvbnm');

        $files = iterator_to_array($volume->lookup($this->getTestDir()));
        sort($files);

        $this->assertEquals(count($testFiles), count($files));
        $this->assertEquals('dummyFile.0.tst', reset($files));
        $this->assertEquals('dummyFile.1.tst', next($files));
        $this->assertEquals('dummyFile.2.tst', next($files));
        $this->assertEquals('dummyFile.tst', next($files));

        $removal = $volume->removeMulti($testFiles);
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.tst'));
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.0.tst'));
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.1.tst'));
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.2.tst'));

        $this->assertEquals([
            'dummyFile.tst' => true,
            'dummyFile.0.tst' => true,
            'dummyFile.1.tst' => true,
            'dummyFile.2.tst' => true,
        ], $removal);
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileSimpleCounter(): void
    {
        $volume = new Target\Volume();
        $this->assertFalse($volume->exists($this->mockTestFile()));
        $this->assertTrue($volume->save($this->mockTestFile(), 15));
        $this->assertTrue($volume->decrement($this->mockTestFile()));
        $this->assertTrue($volume->decrement($this->mockTestFile()));
        $this->assertTrue($volume->increment($this->mockTestFile()));
        $this->assertEquals(14, $volume->load($this->mockTestFile()));
        $this->assertTrue($volume->remove($this->mockTestFile()));
        $this->assertFalse($volume->exists($this->mockTestFile()));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileHarderCounter(): void
    {
        $volume = new Target\Volume();
        $this->assertFalse($volume->exists($this->mockTestFile()));
        $this->assertTrue($volume->decrement($this->mockTestFile()));
        $this->assertTrue($volume->increment($this->mockTestFile()));
        $this->assertEquals(1, $volume->load($this->mockTestFile()));
        $this->assertTrue($volume->remove($this->mockTestFile()));
        $this->assertTrue($volume->increment($this->mockTestFile()));
        $this->assertTrue($volume->decrement($this->mockTestFile()));
        $this->assertEquals(0, $volume->load($this->mockTestFile()));
        $this->assertTrue($volume->remove($this->mockTestFile()));
        $this->assertFalse($volume->exists($this->mockTestFile()));
    }
}

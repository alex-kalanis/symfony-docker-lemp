<?php

namespace ExtrasTests;


use CommonTestClass;
use kalanis\kw_paths\Extras\ExtendDir;
use kalanis\kw_paths\PathsException;


class ExtendTest extends CommonTestClass
{
    public function tearDown(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . DIRECTORY_SEPARATOR . 'for_test';
        if (is_dir($path . DIRECTORY_SEPARATOR . 'desc')) {
            rmdir($path . DIRECTORY_SEPARATOR . 'desc');
        }
        if (is_file($path . DIRECTORY_SEPARATOR . 'desc')) {
            unlink($path . DIRECTORY_SEPARATOR . 'desc');
        }
        if (is_dir($path . DIRECTORY_SEPARATOR . 'thumbs')) {
            rmdir($path . DIRECTORY_SEPARATOR . 'thumbs');
        }
        if (is_file($path . DIRECTORY_SEPARATOR . 'thumbs')) {
            unlink($path . DIRECTORY_SEPARATOR . 'thumbs');
        }
        if (is_dir($path)) {
            rmdir($path);
        }
        if (is_file($path)) {
            unlink($path);
        }
        parent::tearDown();
    }

    public function testBasics(): void
    {
        $lib = $this->getExtend();
        $this->assertEquals(realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'data' ])) . DIRECTORY_SEPARATOR, $lib->getWebRootDir());
        $this->assertEquals('desc', $lib->getDescDir());
        $this->assertEquals('descr', $lib->getDescFile());
        $this->assertEquals('.txt', $lib->getDescExt());
        $this->assertEquals('thumbs', $lib->getThumbDir());
    }

    public function testCreate(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . DIRECTORY_SEPARATOR . 'for_test';
        $lib->createDir('', 'for_test');
        $this->assertTrue($lib->isDir($path));
        $this->assertFalse($lib->isFile($path));
        rmdir($path);
        $this->assertFalse($lib->isDir($path));
    }

    public function testExtended(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        $lib->createDir('', 'for_test');
        $this->assertTrue($lib->makeExtended('for_test'));
        $this->assertTrue($lib->makeExtended('for_test')); // already exists
        touch($path . DIRECTORY_SEPARATOR . $lib->getDescDir() . DIRECTORY_SEPARATOR . 'empty_one');
        mkdir($path . DIRECTORY_SEPARATOR . $lib->getThumbDir() . DIRECTORY_SEPARATOR . 'another_one', 0777);
        $this->assertTrue($lib->removeExtended('for_test'));
        @rmdir($path);
    }

    public function testExtendedFailDescDir(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        $lib->createDir('', 'for_test');
        touch($path . DIRECTORY_SEPARATOR . $lib->getDescDir());
        $this->expectException(PathsException::class);
        $lib->makeExtended('for_test');
        unlink($path . DIRECTORY_SEPARATOR . $lib->getDescDir());
        @rmdir($path);
    }

    public function testExtendedFailThumbDir(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        $lib->createDir('', 'for_test');
        touch($path . DIRECTORY_SEPARATOR . $lib->getThumbDir());
        $this->expectException(PathsException::class);
        $lib->makeExtended('for_test');
        $lib->removeExtended('for_test');
        @rmdir($path);
    }

    public function testReadable1(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        mkdir($path);
        $lib->isReadable($path);
        chmod($path, 0333);
        $this->expectException(PathsException::class);
        $lib->isReadable($path);
        @rmdir($path);
    }

    public function testWritable1(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        mkdir($path);
        $lib->isWritable($path);
        chmod($path, 0444);
        $this->expectException(PathsException::class);
        $lib->isWritable($path);
        @rmdir($path);
    }

    public function testReadable2(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        touch($path);
        $this->expectException(PathsException::class);
        $lib->isReadable($path);
        @unlink($path);
    }

    public function testWritable2(): void
    {
        $lib = $this->getExtend();
        $path = $lib->getWebRootDir() . 'for_test';
        touch($path);
        $this->expectException(PathsException::class);
        $lib->isWritable($path);
        @unlink($path);
    }

    protected function getExtend(): ExtendDir
    {
        return new ExtendDir(
        realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'data' ])) . DIRECTORY_SEPARATOR,
            'desc',
            'descr',
            '.txt',
            'thumbs'
        );
    }
}

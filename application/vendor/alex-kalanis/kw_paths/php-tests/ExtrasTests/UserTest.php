<?php

namespace ExtrasTests;


use CommonTestClass;
use InvalidArgumentException;
use kalanis\kw_paths\Extras\UserDir;
use kalanis\kw_paths\Path;
use kalanis\kw_paths\PathsException;
use UnexpectedValueException;


class UserTest extends CommonTestClass
{
    public function tearDown(): void
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'for_test';
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
        $lib = $this->getUserDir();
        $this->assertEquals(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'data' ]) . DIRECTORY_SEPARATOR, $lib->getWebRootDir());
        $this->assertEmpty($lib->getHomeDir());
        $this->assertEmpty($lib->getWorkDir());
        $this->assertEmpty($lib->getRealDir());
        $this->assertFalse($lib->wantHomeDir(false)->usedHomeDir());
        $this->assertTrue($lib->wantHomeDir(true)->usedHomeDir());
        $this->assertFalse($lib->wantDataDir(false)->usedDataDir());
        $this->assertTrue($lib->wantDataDir(true)->usedDataDir());
    }

    public function testUser(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserName('dummy');
        $this->assertEquals('dummy', $lib->getUserName());
    }

    public function testUserEmpty(): void
    {
        $lib = $this->getUserDir();
        $this->expectException(InvalidArgumentException::class);
        $lib->setUserName('');
    }

    public function testUserInvalid(): void
    {
        $lib = $this->getUserDir();
        $this->expectException(InvalidArgumentException::class);
        $lib->setUserName('which:me');
    }

    /**
     * @param string $path
     * @param bool $fromHomeDir
     * @param bool $useSubDir
     * @dataProvider pathsProvider
     */
    public function testPaths(string $path, bool $fromHomeDir, bool $useSubDir): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath($path);
        $this->assertEquals($path, $lib->getUserPath());
        $this->assertEquals($fromHomeDir, $lib->usedHomeDir());
        $this->assertEquals($useSubDir, $lib->usedDataDir());
    }

    public function pathsProvider(): array
    {
        return [
            ['abc/def/ghi', true, true],
            ['/abc/def/ghi/', false, false],
            ['/abc/def/ghi', false, true],
            ['abc/def/ghi/', true, false],
            ['/', false, false],
            ['', true, true],
        ];
    }

    public function testProcessInvalid(): void
    {
        $lib = $this->getUserDir();
        $this->expectException(UnexpectedValueException::class);
        $lib->process();
    }

    /**
     * @param string $name
     * @param bool $fromHomeDir
     * @param bool $useSubDir
     * @param string $resultPath
     * @dataProvider processNamesProvider
     */
    public function testProcessNames(string $name, bool $fromHomeDir, bool $useSubDir, string $resultPath): void
    {
        $lib = $this->getUserDir();
        $lib->setUserName($name)->wantHomeDir($fromHomeDir)->wantDataDir($useSubDir)->process();
        $this->assertEquals($resultPath, $lib->getUserPath());
    }

    public function processNamesProvider(): array
    {
        return [
            ['dummy', true, true, 'dummy'],
            ['dummy', false, true, '/dummy'],
            ['dummy', false, false, '/dummy/'],
            ['dummy', true, false, 'dummy/'],
        ];
    }

    public function testPathInvalid(): void
    {
        $lib = $this->getUserDir();
        $this->assertFalse($lib->setUserPath('which:me'));
    }

    public function testCreateInvalid1(): void
    {
        $lib = $this->getUserDir();
        touch($lib->getWebRootDir() . 'for_test');
        $this->expectException(PathsException::class);
        $lib->createTree();
        @unlink($lib->getWebRootDir() . 'for_test');
    }

    public function testCreateInvalid2(): void
    {
        $lib = $this->getUserDir();
        touch($lib->getWebRootDir() . 'for_test');
        $lib->setUserPath('/for_test');
        $lib->process();
        $this->expectException(PathsException::class);
        $lib->createTree();
        @unlink($lib->getWebRootDir() . 'for_test');
    }

    public function testCreate(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/for_test');
        $lib->process();
        $lib->createTree();
        $this->assertTrue($lib->wipeConfDirs());
        $this->assertTrue($lib->wipeHomeDir());
    }

    public function testWipeWorkDir(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/dummy/');
        $lib->process();
        $this->assertTrue($lib->wipeWorkDir());
    }

    public function testWipeWorkDirInvalid1(): void
    {
        $lib = $this->getUserDir();
        $this->expectException(PathsException::class);
        $lib->wipeWorkDir();
    }

    public function testWipeWorkDirInvalid2(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/d/');
        $lib->process();
        $this->assertFalse($lib->wipeWorkDir());
    }

    public function testWipeConfDir(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/dummy');
        $lib->process();
        $this->assertTrue($lib->wipeConfDirs());
    }

    public function testWipeConfDirInvalid1(): void
    {
        $lib = $this->getUserDir();
        $this->expectException(PathsException::class);
        $lib->wipeConfDirs();
    }

    public function testWipeConfDirInvalid2(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/d');
        $lib->process();
        $this->assertFalse($lib->wipeConfDirs());
    }

    public function testWipeConfDirInvalid3(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/dummy/');
        $lib->process();
        $this->assertFalse($lib->wipeConfDirs());
    }

    public function testWipeHomeDir(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/dummy');
        $lib->process();
        $this->assertTrue($lib->wipeHomeDir());
    }

    public function testWipeHomeDirInvalid1(): void
    {
        $lib = $this->getUserDir();
        $this->expectException(PathsException::class);
        $lib->wipeHomeDir();
    }

    public function testWipeHomeDirInvalid2(): void
    {
        $lib = $this->getUserDir();
        $lib->setUserPath('/d/');
        $lib->process();
        $this->assertFalse($lib->wipeHomeDir());
    }

    protected function getUserDir(): UserDir
    {
        $path = new Path();
        return new UserDir($path
            ->setDocumentRoot(__DIR__ . '/..')
            ->setPathToSystemRoot('data')
        );
    }
}

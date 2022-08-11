<?php

namespace ExtrasTests;


use kalanis\kw_paths\Extras\DirectoryListing;


class ListingTest extends \CommonTestClass
{
    public function testBasicListing(): void
    {
        $lib = new DirectoryListing();
        $lib->setPath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'target' . DIRECTORY_SEPARATOR);
        $lib->setUsableCallback([$this, 'removeNotMask1']);
        $lib->process();
        $this->assertEquals([2=>
            'dummy1.txt',
            'dummy2.txt',
            'dummy3.txt',
            'dummy4.txt',
        ], $lib->getFiles());
    }

    public function testReverseListing(): void
    {
        $lib = new DirectoryListing();
        $lib->setPath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'target' . DIRECTORY_SEPARATOR);
        $lib->setOrderDesc(true);
        $lib->setUsableCallback([$this, 'removeRootDirs']);
        $lib->process();
        $this->assertEquals([
            'other1.txt',
            'dummy4.txt',
            'dummy3.txt',
        ], $lib->getFilesSliced(1, 3));
    }

    public function removeNotMask1(string $name): bool
    {
        if ('.' == $name[0]) {
            return false;
        }
        return (false !== strpos($name, 'dummy'));
    }

    public function removeRootDirs(string $name): bool
    {
        return ('.' != $name[0]);
    }
}

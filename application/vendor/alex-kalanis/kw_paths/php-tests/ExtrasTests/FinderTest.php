<?php

namespace ExtrasTests;


use CommonTestClass;
use kalanis\kw_paths\Extras\TNameFinder;


class FinderTest extends CommonTestClass
{
    /**
     * @param string $input
     * @param string $expected
     * @dataProvider findProvider1
     */
    public function testFind1(string $input, string $expected): void
    {
        $lib = new NameFinder1();
        $this->assertEquals($expected, $lib->findFreeName($input));
    }

    public function findProvider1(): array
    {
        return [
            ['def.ghi', 'def.ghi'],
            ['/abc//def.ghi', 'abcdef.ghi'],
            ['.ghi', '.ghi'],
            ['example.txt', 'example.2.txt'],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider findProvider2
     */
    public function testFind2(string $input, string $expected): void
    {
        $lib = new NameFinder2();
        $this->assertEquals($expected, $lib->findFreeName($input));
    }

    public function findProvider2(): array
    {
        return [
            ['example.txt', 'example_0.txt'],
        ];
    }
}


class NameFinder1
{
    use TNameFinder;

    protected function getSeparator(): string
    {
        return '.';
    }

    protected function getTargetDir(): string
    {
        return realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'data', 'tree' ])) . DIRECTORY_SEPARATOR;
    }

    protected function targetExists(string $path): bool
    {
        return file_exists($path);
    }
}


class NameFinder2 extends NameFinder1
{
    protected function getSeparator(): string
    {
        return '_';
    }
}

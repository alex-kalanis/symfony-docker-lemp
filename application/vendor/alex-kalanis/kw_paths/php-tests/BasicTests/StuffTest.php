<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Stuff;


class StuffTest extends CommonTestClass
{
    /**
     * @param string $input
     * @param string $expected
     * @dataProvider sanitizeProvider
     */
    public function testSanitize(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::sanitize($input));
    }

    public function sanitizeProvider(): array
    {
        return [
            ['/abc/def/ghi', 'abc/def/ghi'],
            ['/abc/def//ghi', 'abc/def/ghi'],
            ['abc/./def/../ghi', 'abc/def/ghi'],
            ['', ''],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider linkProvider
     */
    public function testLink(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::arrayToLink(Stuff::linkToArray($input)));
    }

    public function linkProvider(): array
    {
        return [
            ['/abc/def//ghi', '/abc/def//ghi'],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider pathProvider
     */
    public function testPath(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::arrayToPath(Stuff::pathToArray($input)));
    }

    public function pathProvider(): array
    {
        return [
            [implode(DIRECTORY_SEPARATOR, ['abc', 'def', '', 'ghi']), implode(DIRECTORY_SEPARATOR, ['abc', 'def', '', 'ghi'])], // OS-independent
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider dirProvider
     */
    public function testDir(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::directory($input));
    }

    public function dirProvider(): array
    {
        return [
            ['/abc/def/ghi', '/abc/def/'],
            ['/abc/def//ghi', '/abc/def//'],
            ['ghi', ''],
            ['', ''],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider fileProvider
     */
    public function testFile(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::filename($input));
    }

    public function fileProvider(): array
    {
        return [
            ['/abc/def/ghi', 'ghi'],
            ['/abc/def//ghi', 'ghi'],
            ['ghi', 'ghi'],
            ['', ''],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider baseProvider
     */
    public function testBase(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::fileBase($input));
    }

    public function baseProvider(): array
    {
        return [
            ['/abc//def.ghi', '/abc//def'],
            ['def.ghi', 'def'],
            ['.ghi', '.ghi'],
            ['', ''],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider extProvider
     */
    public function testExt(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::fileExt($input));
    }

    public function extProvider(): array
    {
        return [
            ['/abc//def.ghi', 'ghi'],
            ['def.ghi', 'ghi'],
            ['.ghi', ''],
            ['', ''],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider endSlashProvider
     */
    public function testEndSlash(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::removeEndingSlash($input));
    }

    public function endSlashProvider(): array
    {
        return [
            [implode(DIRECTORY_SEPARATOR, ['abc', 'def', '', 'ghi']), implode(DIRECTORY_SEPARATOR, ['abc', 'def', '', 'ghi'])], // OS-independent
            [implode(DIRECTORY_SEPARATOR, ['abc', 'def', '', 'ghi', '']), implode(DIRECTORY_SEPARATOR, ['abc', 'def', '', 'ghi'])], // OS-independent
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider canonizeProvider
     */
    public function testCanonize(string $input, string $expected): void
    {
        $this->assertEquals($expected, Stuff::canonize($input));
    }

    public function canonizeProvider(): array
    {
        return [
            ['abcdefghi', 'abcdefghi'],
            ['a&0123;bcdef0123ghi', 'a0123bcdef0123ghi'],
            ['abcde&#123;fghi', 'abcdefghi'],
            ['abcde&copy;fghi', 'abcdefghi'],
            ['a^bcd^e$f g hi', 'abcdef_g_hi'],
            ['abcd^ef hi 0.xxx', 'abcdef_hi_0.xxx'],
            ['abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789', 'abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrs'],
            ['abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz.0123456789', 'abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789abcdefghi.0123456789'],
        ];
    }
}

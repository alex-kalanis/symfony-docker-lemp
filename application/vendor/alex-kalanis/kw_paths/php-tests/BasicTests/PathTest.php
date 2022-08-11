<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\KwPath;
use kalanis\kw_paths\Path;


class PathTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $path = new Path();
        $path->setData(['user'=>'def','module'=>'jkl','mno'=>'pqr',]);
        $path->setDocumentRoot('/abc/def/ghi/jkl');
        $path->setPathToSystemRoot('../mno/pqr');
        $this->assertEquals(implode(DIRECTORY_SEPARATOR, ['', 'abc', 'def', 'ghi', 'jkl']), $path->getDocumentRoot());
        $this->assertEquals(implode(DIRECTORY_SEPARATOR, ['..', 'mno', 'pqr']), $path->getPathToSystemRoot());
        $this->assertEmpty($path->getStaticalPath());
        $this->assertEmpty($path->getVirtualPrefix());
        $this->assertEquals('def', $path->getUser());
        $this->assertEmpty($path->getLang());
        $this->assertEmpty($path->getPath());
        $this->assertEquals('jkl', $path->getModule());
        $this->assertEmpty($path->isSingle());
    }

    public function testKwPath(): void
    {
        $path = new KwPath();
        $path->setPath(implode(DIRECTORY_SEPARATOR, ['', 'abc', '..', 'def.ghi', '.', 'jkl', '', 'mno.pqr']));
        $this->assertEquals(implode(DIRECTORY_SEPARATOR, ['abc', 'def.ghi', 'jkl', 'mno.pqr']), (string) $path);
        $this->assertEquals('mno.pqr', $path->getFileName());
        $this->assertEquals(implode(DIRECTORY_SEPARATOR, ['abc', 'def.ghi', 'jkl']), $path->getDirectory());
        $this->assertEquals(['abc', 'def.ghi', 'jkl', 'mno.pqr'], $path->getArray());

        $path->setPath(implode(DIRECTORY_SEPARATOR,  ['', '.', '..', '.', ''])); // NOPE!
        $this->assertEquals('', (string) $path);
        $this->assertEquals('', $path->getFileName());
        $this->assertEquals('', $path->getDirectory());
        $this->assertEquals([], $path->getArray());

        $path->setPath('abcdef');
        $this->assertEquals('abcdef', (string) $path);
        $this->assertEquals('abcdef', $path->getFileName());
        $this->assertEquals('', $path->getDirectory());
        $this->assertEquals(['abcdef'], $path->getArray());
    }
}

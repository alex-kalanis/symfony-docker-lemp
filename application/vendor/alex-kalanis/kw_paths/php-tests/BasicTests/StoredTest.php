<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Path;
use kalanis\kw_paths\Stored;


class StoredTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');

        $this->assertEmpty(Stored::getPath());
        $this->assertEmpty(Stored::getOriginalPath());

        Stored::init($path);
        $xPath = Stored::getPath();
        $xPath->setPathToSystemRoot('sdfgsdfgt/');
        $this->assertNotEquals(Stored::getOriginalPath(), $xPath);
    }
}

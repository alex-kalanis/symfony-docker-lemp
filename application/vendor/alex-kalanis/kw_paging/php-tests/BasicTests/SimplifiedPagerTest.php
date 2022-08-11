<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paging\Render;
use MockLink;


class SimplifiedPagerTest extends CommonTestClass
{
    /**
     * @param Render\SimplifiedPager\CurrentPage|Render\SimplifiedPager\AnotherPage|Render\SimplifiedPager\DisabledPage $class
     * @param int $page
     * @param string $code
     * @dataProvider simpleProvider
     */
    public function testPages($class, int $page, string $code): void
    {
        $link = new MockLink();
        $link->setPageNumber($page);
        $class->setData($link, strval($page));
        $this->assertEquals($code . PHP_EOL, $class->render());
    }

    public function simpleProvider()
    {
        return [
            [new Render\SimplifiedPager\CurrentPage(), 4, '<li class="active"><a href="/foo/bar/4">4</a></li>'],
            [new Render\SimplifiedPager\CurrentPage(), 1, '<li class="active"><a href="/foo/bar/">1</a></li>'],
            [new Render\SimplifiedPager\AnotherPage(), 4, '<li><a href="/foo/bar/4">4</a></li>'],
            [new Render\SimplifiedPager\AnotherPage(), 1, '<li><a href="/foo/bar/">1</a></li>'],
            [new Render\SimplifiedPager\DisabledPage(), 4, '<li class="disabled"><span>4</span></li>'],
            [new Render\SimplifiedPager\DisabledPage(), 1, '<li class="disabled"><span>1</span></li>'],
        ];
    }

    public function testInstance(): void
    {
        $position = $this->getPositions();
        $position->getPager()->setActualPage(4);
        $pager = new Render\SimplifiedPager($position, new MockLink());
        $this->assertInstanceOf('\kalanis\kw_pager\Interfaces\IPager', $pager->getPager());
    }

    public function testMiddle(): void
    {
        $position = $this->getPositions();
        $position->getPager()->setActualPage(4);
        $pager = new Render\SimplifiedPager($position, new MockLink());
        $this->assertNotEmpty(strval($pager));
    }

    public function testStart(): void
    {
        $position = $this->getPositions();
        $position->getPager()->setActualPage($position->getFirstPage());
        $pager = new Render\SimplifiedPager($position, new MockLink());
        $this->assertNotEmpty(strval($pager));
    }

    public function testEnd(): void
    {
        $position = $this->getPositions();
        $position->getPager()->setActualPage($position->getLastPage());
        $pager = new Render\SimplifiedPager($position, new MockLink());
        $this->assertNotEmpty(strval($pager));
    }

    public function testNothing(): void
    {
        $position = $this->getPositions();
        $position->getPager()->setMaxResults(10)->setActualPage($position->getFirstPage());
        $pager = new Render\SimplifiedPager($position, new MockLink());
        $this->assertEmpty(strval($pager));
    }
}

<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_pager\BasicPager;
use kalanis\kw_pager\DefaultSettings;
use kalanis\kw_pager\Interfaces\IActualInput;
use kalanis\kw_pager\InputPager;


class BasicTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $pager = new BasicPager();
        $pager->setMaxResults(75)->setLimit(12)->setActualPage(4);

        $this->assertTrue($pager->pageExists(6));
        $this->assertTrue($pager->pageExists(7));
        $this->assertFalse($pager->pageExists(8));
        $this->assertFalse($pager->pageExists(-2));
        $this->assertEquals(7, $pager->getPagesCount());

        $this->assertEquals(75, $pager->getMaxResults());
        $this->assertEquals(12, $pager->getLimit());
        $this->assertEquals(4, $pager->getActualPage());
        $this->assertEquals(36, $pager->getOffset());

        // fun begins
        $pager->setActualPage(1); // okay
        $this->assertEquals(0, $pager->getOffset());
        $pager->setActualPage(2);
        $this->assertEquals(12, $pager->getOffset());
        $pager->setActualPage(0); // outside - too low
        $this->assertEquals(0, $pager->getOffset());
        $pager->setActualPage(9); // outside - too high
        $this->assertEquals(0, $pager->getOffset());

        // change limits
        $pager->setLimit(5);
        $this->assertEquals(15, $pager->getPagesCount());
        $pager->setActualPage(9);
        $this->assertEquals(40, $pager->getOffset());
    }

    public function testResults(): void
    {
        $pager = new BasicPager();
        $pager->setLimit(12);
        $pager->setMaxResults(0);
        $pager->setActualPage(7);

        $this->assertEquals(1, $pager->getPagesCount());
        $this->assertEquals(0, $pager->getOffset());
    }

    public function testInput(): void
    {
        $pager = new InputPager(new DefaultSettings(12, 75), new MockInput());

        $this->assertTrue($pager->pageExists(6));
        $this->assertTrue($pager->pageExists(7));
        $this->assertFalse($pager->pageExists(8));
        $this->assertFalse($pager->pageExists(-2));
        $this->assertEquals(7, $pager->getPagesCount());

        $this->assertEquals(75, $pager->getMaxResults());
        $this->assertEquals(12, $pager->getLimit());
        $this->assertEquals(4, $pager->getActualPage());
        $this->assertEquals(36, $pager->getOffset());
    }
}


class MockInput implements IActualInput
{
    public function getActualPage(): int
    {
        return 4;
    }
}
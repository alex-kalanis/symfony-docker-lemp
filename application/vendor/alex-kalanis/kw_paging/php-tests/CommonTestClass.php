<?php

use kalanis\kw_pager\BasicPager;
use kalanis\kw_paging\Interfaces\ILink;
use kalanis\kw_paging\Positions;


class CommonTestClass extends \PHPUnit\Framework\TestCase
{
    protected function getPositions(): Positions
    {
        $position = new Positions(new MockPager());
        $position->getPager()->setMaxResults(75)->setLimit(12);
        return $position;
    }
}


class MockLink implements ILink
{
    protected $link = '/foo/bar/';
    protected $pageNum = 0;

    public function setPageNumber(int $page): void
    {
        $this->pageNum = $page;
    }

    public function getPageLink(): string
    {
        return (1 < $this->pageNum) ? $this->link . $this->pageNum : $this->link ;
    }
}


class MockPager extends BasicPager
{
}

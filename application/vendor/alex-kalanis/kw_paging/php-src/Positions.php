<?php

namespace kalanis\kw_paging;


use kalanis\kw_pager\Interfaces\IPager;


class Positions implements Interfaces\IPositions
{
    const FIRST_PAGE = 1;

    /** @var IPager */
    protected $pager = null;

    public function __construct(IPager $pager)
    {
        $this->pager = $pager;
    }

    public function nextPageExists(): bool
    {
        return $this->pager->pageExists($this->getNextPage());
    }

    public function getNextPage(): int
    {
        return $this->pager->getActualPage() + 1;
    }

    public function prevPageExists(): bool
    {
        return $this->pager->pageExists($this->getPrevPage());
    }

    public function getPrevPage(): int
    {
        return $this->pager->getActualPage() - 1;
    }

    public function getFirstPage(): int
    {
        return static::FIRST_PAGE;
    }

    public function getLastPage(): int
    {
        return $this->pager->getPagesCount();
    }

    public function getPager(): IPager
    {
        return $this->pager;
    }
}

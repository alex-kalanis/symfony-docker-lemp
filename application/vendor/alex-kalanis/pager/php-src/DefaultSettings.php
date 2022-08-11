<?php

namespace kalanis\kw_pager;


class DefaultSettings implements Interfaces\ISettings
{
    /** @var int */
    protected $maxResults = 0;
    /** @var int */
    protected $limitPerPage = 0;

    public function __construct(int $limitPerPage, int $maxResults)
    {
        $this->maxResults = $maxResults;
        $this->limitPerPage = $limitPerPage;
    }

    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    public function getLimit(): int
    {
        return $this->limitPerPage;
    }
}

<?php

namespace kalanis\kw_pager\Interfaces;

/**
 * Interface IPager
 * @package kalanis\kw_pager\Interfaces
 * What you need to know about pager
 */
interface IPager
{
    /**
     * Set maximum available results for paging
     * @param int $maxResults
     * @return $this
     */
    public function setMaxResults(int $maxResults): self;

    /**
     * Returns maximum available results for paging
     * @return int
     */
    public function getMaxResults(): int;

    /**
     * Set current page number
     * @param int $page
     * @return $this
     */
    public function setActualPage(int $page): self;

    /**
     * Returns current page number
     * @return int
     */
    public function getActualPage(): int;

    /**
     * Set limit of items on one page
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit): self;

    /**
     * Returns limit of items on one page
     * @return int
     */
    public function getLimit(): int;

    /**
     * Returns calculated offset
     * @return int
     */
    public function getOffset(): int;

    /**
     * Returns number of available pages
     * @return int
     */
    public function getPagesCount(): int;

    /**
     * Have we that page?
     * @param int $i
     * @return bool
     */
    public function pageExists(int $i): bool;
}
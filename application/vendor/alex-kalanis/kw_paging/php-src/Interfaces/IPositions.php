<?php

namespace kalanis\kw_paging\Interfaces;


use kalanis\kw_pager\Interfaces\IPager;


/**
 * Interface IPositions
 * @package kalanis\kw_paging\Interfaces
 * Positions of pages in the pager
 */
interface IPositions
{
    const DEFAULT_DISPLAY_PAGES_COUNT = 10;

    /**
     * Exists next page?
     * @return bool
     */
    public function nextPageExists(): bool;

    /**
     * Return number of next page
     * @return int
     */
    public function getNextPage(): int;

    /**
     * Exists previous page?
     * @return bool
     */
    public function prevPageExists(): bool;

    /**
     * Return number of previous page
     * @return int
     */
    public function getPrevPage(): int;

    /**
     * Return number of first page
     * @return int
     */
    public function getFirstPage(): int;

    /**
     * Return number of last page
     * @return int
     */
    public function getLastPage(): int;

    /**
     * Get used pager
     * @return IPager
     */
    public function getPager(): IPager;
}

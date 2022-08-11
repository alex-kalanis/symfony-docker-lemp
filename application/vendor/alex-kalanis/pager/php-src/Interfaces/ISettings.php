<?php

namespace kalanis\kw_pager\Interfaces;


/**
 * Interface ISettings
 * @package kalanis\kw_pager\Interfaces
 * Default settings for paging through records
 */
interface ISettings
{
    /**
     * Returns maximum available results for paging on following objects
     * @return int
     */
    public function getMaxResults(): int;

    /**
     * Returns limit of items on one page
     * @return int
     */
    public function getLimit(): int;
}

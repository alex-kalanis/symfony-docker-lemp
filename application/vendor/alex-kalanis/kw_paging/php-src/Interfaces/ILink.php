<?php

namespace kalanis\kw_paging\Interfaces;


/**
 * Interface ILink
 * @package kalanis\kw_paging\Interfaces
 * Link generator
 */
interface ILink
{
    /**
     * Set number of used page
     * @param int $page
     */
    public function setPageNumber(int $page): void;

    /**
     * Return complete link with page
     * @return string
     */
    public function getPageLink(): string;
}

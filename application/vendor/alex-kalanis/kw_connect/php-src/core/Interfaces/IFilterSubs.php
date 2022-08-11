<?php

namespace kalanis\kw_connect\core\Interfaces;


/**
 * Interface IFilterSubs
 * @package kalanis\kw_connect\core\Interfaces
 * Contains filters
 */
interface IFilterSubs extends IFilterType
{
    /**
     * @param IFilterFactory $factory
     */
    public function addFilterFactory(IFilterFactory $factory): void;
}

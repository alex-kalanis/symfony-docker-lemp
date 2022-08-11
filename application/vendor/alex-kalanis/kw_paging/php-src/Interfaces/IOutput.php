<?php

namespace kalanis\kw_paging\Interfaces;


use kalanis\kw_pager\Interfaces\IPager;


/**
 * Interface IOutput
 * @package kalanis\kw_paging\Interfaces
 * What will be printed on output
 */
interface IOutput
{
    /**
     * Return complete link with page
     * @return string
     */
    public function render(): string;

    /**
     * Return pager with which it's rendered
     * @return IPager
     */
    public function getPager(): IPager;
}

<?php

namespace kalanis\kw_pager\Interfaces;


/**
 * Interface IActualPage
 * @package kalanis\kw_pager\Interfaces
 * Info from inputs on which page we are
 */
interface IActualInput
{
    /**
     * Returns current page number
     * @return int
     */
    public function getActualPage(): int;
}

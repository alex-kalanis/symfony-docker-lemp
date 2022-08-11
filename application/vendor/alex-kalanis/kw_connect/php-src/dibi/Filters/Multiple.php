<?php

namespace kalanis\kw_connect\dibi\Filters;


use kalanis\kw_connect\core\Interfaces\IFilterSubs;
use kalanis\kw_connect\core\TMultiple;


/**
 * Class Multiple
 * @package kalanis\kw_connect\dibi\Filters
 */
class Multiple extends AType implements IFilterSubs
{
    use TMultiple;

    protected function getDataSourceName(): string
    {
        return 'dibiFluent';
    }
}

<?php

namespace kalanis\kw_connect\arrays\Filters;


use kalanis\kw_connect\core\AFilterFactory;


/**
 * Class ArrayFactory
 * @package kalanis\kw_connect\Filters\arrays
 * Factory Class for accessing filter types
 */
class Factory extends AFilterFactory
{
    protected static $map = [
        self::ACTION_CONTAINS => '\kalanis\kw_connect\arrays\Filters\Contains',
        self::ACTION_EXACT => '\kalanis\kw_connect\arrays\Filters\Exact',
        self::ACTION_FROM => '\kalanis\kw_connect\arrays\Filters\From',
        self::ACTION_FROM_WITH => '\kalanis\kw_connect\arrays\Filters\FromWith',
        self::ACTION_TO => '\kalanis\kw_connect\arrays\Filters\To',
        self::ACTION_TO_WITH => '\kalanis\kw_connect\arrays\Filters\ToWith',
        self::ACTION_RANGE => '\kalanis\kw_connect\arrays\Filters\Range',
        self::ACTION_MULTIPLE => '\kalanis\kw_connect\arrays\Filters\Multiple',
    ];
}

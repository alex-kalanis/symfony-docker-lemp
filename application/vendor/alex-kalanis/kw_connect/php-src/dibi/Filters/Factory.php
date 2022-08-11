<?php

namespace kalanis\kw_connect\dibi\Filters;


use kalanis\kw_connect\core\AFilterFactory;


/**
 * Class Factory
 * @package kalanis\kw_connect\dibi\Filters
 * Factory Class for accessing filter types
 */
class Factory extends AFilterFactory
{
    protected static $map = [
        self::ACTION_EXACT => '\kalanis\kw_connect\dibi\Filters\Exact',
        self::ACTION_CONTAINS => '\kalanis\kw_connect\dibi\Filters\Contains',
        self::ACTION_FROM => '\kalanis\kw_connect\dibi\Filters\From',
        self::ACTION_FROM_WITH => '\kalanis\kw_connect\dibi\Filters\FromWith',
        self::ACTION_TO => '\kalanis\kw_connect\dibi\Filters\To',
        self::ACTION_TO_WITH => '\kalanis\kw_connect\dibi\Filters\ToWith',
        self::ACTION_RANGE => '\kalanis\kw_connect\dibi\Filters\Range',
        self::ACTION_MULTIPLE => '\kalanis\kw_connect\dibi\Filters\Multiple',
    ];
}

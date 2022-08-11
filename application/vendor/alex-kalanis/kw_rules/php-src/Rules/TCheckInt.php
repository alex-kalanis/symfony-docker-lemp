<?php

namespace kalanis\kw_rules\Rules;


/**
 * trait TCheckInt
 * @package kalanis\kw_rules\Rules
 * Check original value as integer
 */
trait TCheckInt
{
    use TRule;

    protected function checkValue($againstValue)
    {
        return intval($againstValue);
    }
}

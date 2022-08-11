<?php

namespace kalanis\kw_rules\Rules;


/**
 * trait TCheckString
 * @package kalanis\kw_rules\Rules
 * Check original value as string
 */
trait TCheckString
{
    use TRule;

    protected function checkValue($againstValue)
    {
        return strval($againstValue);
    }
}

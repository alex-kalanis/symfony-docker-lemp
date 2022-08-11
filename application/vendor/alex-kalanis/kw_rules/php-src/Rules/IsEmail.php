<?php

namespace kalanis\kw_rules\Rules;


/**
 * Class IsEmail
 * @package kalanis\kw_rules\Rules
 * Check if input is email
 */
class IsEmail extends MatchesPattern
{
    protected function checkValue(/** @scrutinizer ignore-unused */ $againstValue)
    {
        return '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,11}$/'; # simple email regex
    }
}

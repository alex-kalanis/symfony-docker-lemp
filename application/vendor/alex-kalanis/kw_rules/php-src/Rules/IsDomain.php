<?php

namespace kalanis\kw_rules\Rules;


/**
 * Class IsDomain
 * @package kalanis\kw_rules\Rules
 * Check if input is domain
 */
class IsDomain extends MatchesPattern
{
    protected function checkValue(/** @scrutinizer ignore-unused */ $againstValue)
    {
        return '/^([0-9a-z][-]?){0,63}[.][a-z]{2,9}$/'; # simple domain regex
    }
}

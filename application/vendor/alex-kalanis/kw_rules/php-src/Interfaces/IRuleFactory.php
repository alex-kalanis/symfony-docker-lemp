<?php

namespace kalanis\kw_rules\Interfaces;


use kalanis\kw_rules\Rules\ARule;
use kalanis\kw_rules\Rules\File\AFileRule;


/**
 * Interface IRuleFactory
 * @package kalanis\kw_rules\Interfaces
 * Which rules are available for that class
 */
interface IRuleFactory
{
    /**
     * Get rule based on its name
     * @param string $ruleName
     * @return ARule|AFileRule
     */
    public function getRule(string $ruleName);
}

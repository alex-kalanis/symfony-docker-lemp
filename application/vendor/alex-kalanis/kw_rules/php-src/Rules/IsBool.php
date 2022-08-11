<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class IsBool
 * @package kalanis\kw_rules\Rules
 * Check if input is boolean
 */
class IsBool extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (!is_bool($entry->getValue())) {
            throw new RuleException($this->errorText);
        }
    }
}

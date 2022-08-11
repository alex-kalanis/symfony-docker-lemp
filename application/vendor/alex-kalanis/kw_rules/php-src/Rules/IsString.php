<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class IsString
 * @package kalanis\kw_rules\Rules
 * Check if input is string
 */
class IsString extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (!is_string($entry->getValue())) {
            throw new RuleException($this->errorText);
        }
    }
}

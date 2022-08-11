<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class IsNumeric
 * @package kalanis\kw_rules\Rules
 * Check if input is numeric
 */
class IsNumeric extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (!is_numeric($entry->getValue())) {
            throw new RuleException($this->errorText);
        }
    }
}

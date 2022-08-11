<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class NotEquals
 * @package kalanis\kw_rules\Rules
 * Check if input is not equal to expected value
 */
class NotEquals extends ARule
{
    public function validate(IValidate $entry): void
    {
        if ($entry->getValue() == $this->againstValue) {
            throw new RuleException($this->errorText);
        }
    }
}

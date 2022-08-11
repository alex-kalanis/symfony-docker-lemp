<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class GreaterEquals
 * @package kalanis\kw_rules\Rules
 * Check if input is greater or equals to expected value
 */
class GreaterEquals extends ARule
{
    use TCheckInt;

    public function validate(IValidate $entry): void
    {
        if (floatval($entry->getValue()) < $this->againstValue) {
            throw new RuleException($this->errorText);
        }
    }
}

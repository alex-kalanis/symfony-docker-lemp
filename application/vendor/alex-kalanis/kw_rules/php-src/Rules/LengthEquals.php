<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class LengthEquals
 * @package kalanis\kw_rules\Rules
 * Check if input length equals expected value
 */
class LengthEquals extends ARule
{
    use TCheckInt;

    public function validate(IValidate $entry): void
    {
        if (mb_strlen(strval($entry->getValue())) != $this->againstValue) {
            throw new RuleException($this->errorText);
        }
    }
}

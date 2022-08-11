<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class LengthMin
 * @package kalanis\kw_rules\Rules
 * Check if input is longer than expected value
 */
class LengthMin extends ARule
{
    use TCheckInt;

    public function validate(IValidate $entry): void
    {
        if (mb_strlen(strval($entry->getValue())) < $this->againstValue) {
            throw new RuleException($this->errorText);
        }
    }
}

<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class IsInArray
 * @package kalanis\kw_rules\Rules
 * Check if input is in preset array
 */
class IsInArray extends ARule
{
    use TCheckArrayString;

    public function validate(IValidate $entry): void
    {
        if (!in_array(strval($entry->getValue()), (array) $this->againstValue)) {
            throw new RuleException($this->errorText);
        }
    }
}

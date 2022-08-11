<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class IsJsonString
 * @package kalanis\kw_rules\Rules
 * Check if input is JSON string
 */
class IsJsonString extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (!(is_string($entry->getValue()) || is_numeric($entry->getValue()))) {
            throw new RuleException($this->errorText);
        }
        json_decode(strval($entry->getValue()));
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuleException($this->errorText, 0, new RuleException(json_last_error_msg()));
        }
    }
}

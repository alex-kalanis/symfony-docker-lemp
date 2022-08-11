<?php

namespace kalanis\kw_rules\Rules\Safe;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;


/**
 * Class HashedFuncEquals
 * @package kalanis\kw_rules\Rules\Safe
 * Check if input is equal to expected value via its hashes
 */
class HashedFuncEquals extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (!hash_equals( strval($this->againstValue), strval($entry->getValue()) )) {
            throw new RuleException($this->errorText);
        }
    }
}

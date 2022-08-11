<?php

namespace kalanis\kw_rules\Rules\Safe;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;


/**
 * Class HashedPassEquals
 * @package kalanis\kw_rules\Rules\Safe
 * Check if input password is equal to expected value via its hashes
 * @codeCoverageIgnore who want to write this test?
 */
class HashedPassEquals extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (!password_verify( strval($entry->getValue()), strval($this->againstValue) )) {
            throw new RuleException($this->errorText);
        }
    }
}

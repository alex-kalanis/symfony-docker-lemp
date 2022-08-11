<?php

namespace kalanis\kw_rules\Rules\Safe;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;


/**
 * Class HashedBasicEquals
 * @package kalanis\kw_rules\Rules\Safe
 * Check if input hash is equal to hash of expected value
 */
class HashedBasicEquals extends ARule
{
    public function validate(IValidate $entry): void
    {
        if ($this->hash(strval($entry->getValue())) != $this->hash(strval($this->againstValue))) {
            throw new RuleException($this->errorText);
        }
    }

    protected function hash(string $input): string
    {
        return md5($input);
    }
}

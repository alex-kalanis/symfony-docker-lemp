<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces;


/**
 * Class MatchByEntry
 * @package kalanis\kw_rules\Rules
 * Check if input matches rules by another entry
 * It's for things like checking phone number or post code with external source of country code
 */
class MatchByEntry extends ARule
{
    use TCheckEntry;

    /** @var Interfaces\IValidate */
    protected $againstValue;

    public function validate(Interfaces\IValidate $entry): void
    {
        foreach ($this->againstValue->getRules() as $rule) {
            $rule->validate($this->againstValue);
        }

        foreach ($entry->getRules() as $rule) {
            $rule->setAgainstValue($this->againstValue->getValue());
            $rule->validate($entry);
        }
    }
}

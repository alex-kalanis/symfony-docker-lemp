<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class InRange
 * @package kalanis\kw_rules\Rules
 * Check if input is in set range
 */
class InRange extends ARule
{
    use TCheckRange;

    public function validate(IValidate $entry): void
    {
        $varToCheck = floatval($entry->getValue());
        if ($varToCheck > $this->againstValue[0] && $varToCheck < $this->againstValue[1]) {
            return;
        }
        throw new RuleException($this->errorText);
    }
}

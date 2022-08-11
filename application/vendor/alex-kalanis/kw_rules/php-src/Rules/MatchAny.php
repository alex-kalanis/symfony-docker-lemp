<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class MatchAny
 * @package kalanis\kw_rules\Rules
 * Check if input matches any subrule
 */
class MatchAny extends ARule
{
    use TCheckRules;

    public function validate(IValidate $entry): void
    {
        $last = null;
        foreach ($this->againstValue as $item) {
            /** @var ARule $item */
            try {
                $item->validate($entry);
                return; // one matched, need no more lookup
            } catch (RuleException $ex) {
                // not good, continue for any other
                $ex->setPrev($last);
                $last = $ex;
            }
        }
        throw new RuleException($this->errorText, 0, $last);
    }
}

<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class MatchAll
 * @package kalanis\kw_rules\Rules
 * Check if input matches all subrules
 */
class MatchAll extends ARule
{
    use TCheckRules;

    public function validate(IValidate $entry): void
    {
        $last = null;
        foreach ($this->againstValue as $item) {
            /** @var ARule $item */
            try {
                $item->validate($entry);
            } catch (RuleException $ex) {
                // not good, continue for any other
                $ex->setPrev($last);
                $last = $ex;
            }
        }
        if (!empty($last)) {
            // it will die when something has been found
            throw new RuleException($this->errorText, 0, $last);
        }
    }
}

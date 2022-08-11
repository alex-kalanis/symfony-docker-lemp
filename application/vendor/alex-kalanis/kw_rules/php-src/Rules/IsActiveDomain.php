<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class IsActiveDomain
 * @package kalanis\kw_rules\Rules
 * Check if input is active domain - makes DNS request!
 * @codeCoverageIgnore Remote query
 */
class IsActiveDomain extends ARule
{
    public function validate(IValidate $entry): void
    {
        if (filter_var(gethostbyname(strval($entry->getValue())), FILTER_VALIDATE_IP)) {
            return;
        }
        throw new RuleException($this->errorText);
    }
}

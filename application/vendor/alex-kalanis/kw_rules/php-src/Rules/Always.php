<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class Always
 * @package kalanis\kw_rules\Rules
 * Is always thrown
 * For passing other errors into rules
 */
class Always extends ARule
{
    public function validate(IValidate $entry): void
    {
        throw new RuleException($this->errorText);
    }
}

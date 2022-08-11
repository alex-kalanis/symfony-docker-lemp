<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class ProcessCallback
 * @package kalanis\kw_rules\Rules
 * Check if input is accepted by callback
 */
class ProcessCallback extends ARule
{
    /**
     * @param mixed $againstValue
     * @throws RuleException
     * @return callable
     */
    protected function checkValue($againstValue)
    {
        if (!is_callable($againstValue)) {
            throw new RuleException('Not callable. Need set call which returns boolean or throws RuleException!');
        }
        return $againstValue;
    }

    public function validate(IValidate $entry): void
    {
        if (!call_user_func(/** @scrutinizer ignore-type */ $this->againstValue, $entry->getValue())) {
            throw new RuleException($this->errorText);
        }
    }
}

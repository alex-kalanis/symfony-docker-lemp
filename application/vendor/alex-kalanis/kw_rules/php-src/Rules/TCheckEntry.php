<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Interfaces\IValidate;


/**
 * trait TCheckEntry
 * @package kalanis\kw_rules\Rules
 * Check original values as another entry
 */
trait TCheckEntry
{
    use TRule;

    /**
     * @param mixed|null $againstValue
     * @throws RuleException
     * @return IValidate
     */
    protected function checkValue($againstValue)
    {
        if (!is_object($againstValue)) {
            throw new RuleException('Input is not an object.');
        }
        if (! ($againstValue instanceof IValidate) ) {
            throw new RuleException(sprintf('Input %s is not instance of IValidate.', get_class($againstValue)));
        }
        return $againstValue;
    }
}

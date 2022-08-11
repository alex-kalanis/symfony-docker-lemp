<?php

namespace kalanis\kw_rules\Rules\External;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;


/**
 * Class IsDate
 * @package kalanis\kw_rules\Rules\External
 * Check if input is date for preset format
 * @link http://schoolsofweb.com/how-to-check-valid-date-format-in-php/
 * Beware! It depends on PHP's parsing! Better use something else.
 * @codeCoverageIgnore when I wrote tests I have zero will for defining all available date formats
 */
class IsDate extends ARule
{
    public function validate(IValidate $entry): void
    {
        $dtInfo = date_parse($entry->getValue());
        if (0 == $dtInfo['warning_count'] && 0 == $dtInfo['error_count']) {
            return;
        }
        throw new RuleException($this->errorText);
    }
}

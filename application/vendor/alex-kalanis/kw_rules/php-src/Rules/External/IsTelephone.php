<?php

namespace kalanis\kw_rules\Rules\External;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;
use kalanis\kw_rules\Rules\TCheckString;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;


/**
 * Class IsTelephone
 * @package kalanis\kw_rules\Rules\External
 * Check if input is telephone for preset country
 * @link https://github.com/giggsey/libphonenumber-for-php
 * @codeCoverageIgnore need external libraries
 */
class IsTelephone extends ARule
{
    use TCheckString;

    public function validate(IValidate $entry): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $number = $phoneUtil->parse($entry->getValue(), $this->againstValue);
            if ($phoneUtil->isValidNumber($number)) {
                return;
            }
            throw new RuleException($this->errorText);
        } catch (NumberParseException $e) {
            throw new RuleException($this->errorText, 0, $e);
        }
    }
}

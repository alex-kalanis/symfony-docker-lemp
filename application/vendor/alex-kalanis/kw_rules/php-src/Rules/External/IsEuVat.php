<?php

namespace kalanis\kw_rules\Rules\External;


use Ddeboer\Vatin\Validator;
use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;


/**
 * Class IsEuVat
 * @package kalanis\kw_rules\Rules\External
 * Check if input is EU VAT number for preset country
 * @link https://github.com/topics/vat-number
 * @link https://github.com/ddeboer/vatin
 * @codeCoverageIgnore need external libraries
 */
class IsEuVat extends ARule
{
    public function validate(IValidate $entry): void
    {
        $validator = new Validator();
        if (!$validator->isValid($entry->getValue(), true)) {
            throw new RuleException($this->errorText);
        }
    }
}

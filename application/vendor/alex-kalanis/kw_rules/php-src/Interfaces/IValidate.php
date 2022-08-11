<?php

namespace kalanis\kw_rules\Interfaces;


use kalanis\kw_rules\Rules;


/**
 * Interface IValidate
 * @package kalanis\kw_rules\Interfaces
 * Interface for validating values
 */
interface IValidate
{
    /**
     * Key which will be validated
     * @return string
     */
    public function getKey(): string;

    /**
     * Value to validate
     * @return mixed
     */
    public function getValue();

    /**
     * What rules will be validated
     * @return Rules\ARule[]|Rules\File\AFileRule[]
     */
    public function getRules(): array;
}

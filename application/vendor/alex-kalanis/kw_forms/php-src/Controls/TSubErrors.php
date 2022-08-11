<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Trait TSubErrors
 * @package kalanis\kw_forms\Controls
 * Trait for processing errors
 */
trait TSubErrors
{
    /** @var array<string, array<int, RuleException>> */
    protected $errors = [];

    /**
     * @return array<string, array<int, RuleException>>
     */
    public function getValidatedErrors(): array
    {
        return $this->errors;
    }
}

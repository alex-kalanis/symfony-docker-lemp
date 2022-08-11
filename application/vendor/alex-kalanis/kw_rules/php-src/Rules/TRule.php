<?php

namespace kalanis\kw_rules\Rules;


/**
 * Trait TRule
 * @package kalanis\kw_rules\Rules
 * Abstract for checking input - What is available for both usual inputs and files
 */
trait TRule
{
    /** @var mixed|null */
    protected $againstValue = null;
    /** @var string */
    protected $errorText = '';

    /**
     * @param mixed|null $againstValue
     */
    public function setAgainstValue($againstValue): void
    {
        $this->againstValue = $this->checkValue($againstValue);
    }

    /**
     * @param mixed|null $againstValue
     * @return mixed|null
     */
    protected function checkValue($againstValue)
    {
        return $againstValue;
    }

    public function setErrorText(string $errorText): void
    {
        $this->errorText = $errorText;
    }
}

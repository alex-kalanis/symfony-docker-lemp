<?php

namespace kalanis\kw_rules;


use kalanis\kw_rules\Interfaces;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Trait TValidate
 * @package kalanis\kw_rules
 * Main class for validation - use it as include for your case
 */
trait TValidate
{
    /** @var RuleException[][] */
    protected $errors = [];

    public function validate(Interfaces\IValidate $entry): bool
    {
        $this->errors = [];
        foreach ($entry->getRules() as $rule) {
            try {
                $rule->validate($entry); // for files need a whole object, so pack it all
            } catch (RuleException $ex) {
                if (empty($this->errors[$entry->getKey()])) {
                    $this->errors[$entry->getKey()] = [];
                }
                $this->errors[$entry->getKey()][] = $ex;
                while ($ex = $ex->/** @scrutinizer ignore-call */getPrev()) {
                    $this->errors[$entry->getKey()][] = $ex;
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * @return RuleException[][]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

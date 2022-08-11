<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\TRule;


/**
 * Class AFileRule
 * @package kalanis\kw_rules\Rules\File
 * Abstract for checking files - must be extra due need of file-specific attributes
 */
abstract class AFileRule
{
    use TRule;

    /**
     * @param IValidateFile $entry
     * @throws RuleException
     * @return void
     */
    abstract public function validate(IValidateFile $entry): void;
}

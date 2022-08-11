<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class FileSent
 * @package kalanis\kw_rules\Rules\File
 * Check if input file has been sent
 */
class FileSent extends AFileRule
{
    public function validate(IValidateFile $entry): void
    {
        if (UPLOAD_ERR_NO_FILE === $entry->getError()) {
            throw new RuleException($this->errorText);
        }
    }
}

<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class FileReceived
 * @package kalanis\kw_rules\Rules\File
 * Check if input file has been received
 */
class FileReceived extends AFileRule
{
    public function validate(IValidateFile $entry): void
    {
        if (UPLOAD_ERR_OK !== $entry->getError()) {
            throw new RuleException($this->errorText);
        }
    }
}

<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class ImageIs
 * @package kalanis\kw_rules\Rules\File
 * Check if input is image
 */
class ImageIs extends AFileRule
{
    public function validate(IValidateFile $entry): void
    {
        $filename = $entry->getTempName();
        if (!empty($filename)) {
            $imageSize = @getimagesize($filename);
            if (false !== $imageSize) {
                return;
            }
        }
        throw new RuleException($this->errorText);
    }
}

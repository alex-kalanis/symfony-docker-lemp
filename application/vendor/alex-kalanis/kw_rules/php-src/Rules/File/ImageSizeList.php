<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\TCheckArrayRange;


/**
 * Class ImageSizeList
 * @package kalanis\kw_rules\Rules\File
 * Check if input image size is in list of preset ones
 */
class ImageSizeList extends AFileRule
{
    use TCheckArrayRange;

    public function validate(IValidateFile $entry): void
    {
        $filename = $entry->getTempName();
        if (!empty($filename)) {
            $imageSize = @getimagesize($filename);
            if (false !== $imageSize) {
                foreach ($this->againstValue as $argument) {
                    if (($imageSize[0] == $argument[0]) && ($imageSize[1] == $argument[1])) {
                        return;
                    }
                }
            }
        }

        throw new RuleException($this->errorText);
    }
}

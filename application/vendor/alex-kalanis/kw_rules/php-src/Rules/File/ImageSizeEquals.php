<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\TCheckRange;


/**
 * Class ImageSizeEquals
 * @package kalanis\kw_rules\Rules\File
 * Check if input image size equals preset ones
 */
class ImageSizeEquals extends AFileRule
{
    use TCheckRange;

    public function validate(IValidateFile $entry): void
    {
        $filename = $entry->getTempName();
        if (!empty($filename)) {
            $imageSize = @getimagesize($filename);
            if (false !== $imageSize) {
                if (($imageSize[0] == $this->againstValue[0]) && ($imageSize[1] == $this->againstValue[1])) {
                    return;
                }
            }
        }
        throw new RuleException($this->errorText);
    }

    protected function checkValue($againstValue)
    {
        if (!is_array($againstValue)) {
            throw new RuleException('No array found. Need set both values to compare!');
        }
        return array_map([$this, 'checkRule'], $againstValue);
    }
}

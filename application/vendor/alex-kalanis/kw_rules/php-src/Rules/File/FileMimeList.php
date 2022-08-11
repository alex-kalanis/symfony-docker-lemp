<?php

namespace kalanis\kw_rules\Rules\File;


use finfo;
use kalanis\kw_rules\Interfaces\IValidateFile;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\TCheckArrayString;


/**
 * Class FileMimeList
 * @package kalanis\kw_rules\Rules\File
 * Check if input file has correct mime type
 */
class FileMimeList extends AFileRule
{
    use TCheckArrayString;

    public function validate(IValidateFile $entry): void
    {
        $filename = $entry->getTempName();
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (!empty($filename)) {
            foreach ($this->againstValue as $argumentValue) {
                if ($finfo->file($filename) == $argumentValue) {
                    return;
                }
            }
        }
        throw new RuleException($this->errorText);
    }

    /**
     * @param mixed|null $singleRule
     * @throws RuleException
     * @return string
     */
    protected function checkRule($singleRule): string
    {
        if (!is_string($singleRule)) {
            throw new RuleException('Input for check is not a string.');
        }
        return $singleRule;
    }
}

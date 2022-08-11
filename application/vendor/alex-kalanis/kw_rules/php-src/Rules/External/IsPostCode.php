<?php

namespace kalanis\kw_rules\Rules\External;


use kalanis\kw_rules\Interfaces\IValidate;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Rules\ARule;
use kalanis\kw_rules\Rules\TCheckString;


/**
 * Class IsPostCode
 * @package kalanis\kw_rules\Rules\External
 * Check if input is post code for preset country
 * @link https://gist.github.com/jamesbar2/1c677c22df8f21e869cca7e439fc3f5b
 * @codeCoverageIgnore need external source
 */
class IsPostCode extends ARule
{
    use TCheckString;

    /** @var array<string, array<string, string>> */
    protected static $codes = [];

    public static function loadCodes(string $pathToCodes): void
    {
        $codeFile = strval(file_get_contents($pathToCodes));
        /** @var array<int, array<string, string>> $codes */
        $codes = json_decode($codeFile, true);
        static::$codes = array_combine(
            array_column($codes, 'ISO'),
            $codes
        );
    }

    public function validate(IValidate $entry): void
    {
        if (!isset(static::$codes[$this->againstValue])) {
            throw new RuleException(sprintf('Unknown preset ISO key for country %s', $this->againstValue) );
        }
        $rule = static::$codes[$this->againstValue];
        if (empty($rule['Regex']) && empty($entry->getValue())) {
            return;
        }
        if (!boolval(preg_match($rule['Regex'], $entry->getValue()))) {
            throw new RuleException($this->errorText);
        }
    }
}

<?php

namespace kalanis\kw_input\Parsers;


/**
 * Class Cli
 * @package kalanis\kw_input\Parsers
 * Parse input from command line
 * Also accepts multiple params and returns them as array
 */
class Cli extends AParser
{
    const DELIMITER_LONG_ENTRY = '--';
    const DELIMITER_SHORT_ENTRY = '-';
    const DELIMITER_PARAM_VALUE = '=';
    const UNSORTED_PARAM = 'param_';

    /** @var string[] */
    protected static $availableLetters = ['a','b','c','d','e','f','g','h','i','j','k','l','m',
                                          'n','o','p','q','r','s','t','u','v','w','x','y','z'];

    /**
     * @param int[]|string[] $input is $argv in boot time
     * @return array<string|int, string|int|bool>|array<string|int, array<int, string|int|bool>>
     */
    public function parseInput(array $input): array
    {
        $clearArray = [];
        $unsorted = 0;
        foreach ($input as &$posted) {
            if (0 === strpos(strval($posted), static::DELIMITER_LONG_ENTRY)) {
                // large params
                $entry = substr(strval($posted), strlen(static::DELIMITER_LONG_ENTRY));
                if (false !== strpos(strval($posted), static::DELIMITER_PARAM_VALUE)) {
                    // we have got some value, so prepare it
                    list($key, $value) = explode(static::DELIMITER_PARAM_VALUE, $entry, 2);
                    $addKey = $this->removeNullBytes($key);
                    $addValue = $this->removeNullBytes($value);
                } else {
                    // we have no value set
                    $addKey = $this->removeNullBytes($entry);
                    $addValue = true;
                }

                if (isset($clearArray[$addKey])) {
                    // if there is multiple inputs with the same key, propagate it as array
                    if (!is_array($clearArray[$addKey])) {
                        $clearArray[$addKey] = [$clearArray[$addKey]];
                    }
                    $clearArray[$addKey][] = $addValue;
                } else { // otherwise simple add
                    $clearArray[$addKey] = $addValue;
                }
            } elseif (0 === strpos(strval($posted), static::DELIMITER_SHORT_ENTRY)) {
                // just by letters
                $entry = $this->removeNullBytes(substr(strval($posted), strlen(static::DELIMITER_SHORT_ENTRY)));
                for ($i=0; $i<strlen($entry); $i++) {
                    if (in_array(strtolower($entry[$i]), static::$availableLetters)) {
                        $clearArray[$entry[$i]] = true;
                    }
                }
            } else {
                // rest of the world
                $key = static::UNSORTED_PARAM . $unsorted;
                $clearArray[$key] = $this->removeNullBytes(strval($posted));
                $unsorted++;
            }
        }
        return $clearArray;
    }
}

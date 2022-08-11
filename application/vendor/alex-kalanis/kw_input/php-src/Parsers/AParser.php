<?php

namespace kalanis\kw_input\Parsers;


/**
 * Class AParser
 * @package kalanis\kw_input\Parsers
 * Parse any input for problematic chars
 */
abstract class AParser
{
    /**
     * Parse input into usable array, remove problematic things
     * @param int[]|string[]|int[][]|string[][] $input
     * @return int[]|string[]|int[][]|string[][]
     */
    abstract public function parseInput(array $input): array;

    /**
     * Clear Null bytes
     * Do not use on files - they are usually valid
     * @param string $string
     * @param string $nullTo
     * @return string
     * @link https://resources.infosecinstitute.com/null-byte-injection-php/
     */
    protected function removeNullBytes($string, $nullTo = '')
    {
        return str_replace(chr(0), $nullTo, $string);
    }
}

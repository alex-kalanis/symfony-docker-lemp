<?php

namespace kalanis\kw_input\Parsers;


/**
 * Class Basic
 * @package kalanis\kw_input\Parsers
 * Parse any input for problematic chars
 */
class Basic extends AParser
{
    public function parseInput(array $input): array
    {
        $trimArray = [];
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $trimArray[$this->removeNullBytes($key)] = $this->parseInput($value);
            } else {
                $trimArray[$this->removeNullBytes($key)] = $this->removeNullBytes(trim(strval($value)));
            }
        }
        // @phpstan-ignore-next-line
        return $trimArray;
    }
}

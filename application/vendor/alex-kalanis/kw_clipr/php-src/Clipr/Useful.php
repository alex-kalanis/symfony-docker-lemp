<?php

namespace kalanis\kw_clipr\Clipr;


use kalanis\kw_input\Interfaces\IEntry;
use kalanis\kw_input\Parsers\Cli;


/**
 * Class Useful
 * @package kalanis\kw_clipr\Clipr
 */
class Useful
{
    /**
     * mb_str_pad
     *
     * @param string $input
     * @param int $pad_length
     * @param string $pad_string
     * @param int $pad_type
     * @return string
     * @author Kari "Haprog" Sderholm https://gist.github.com/nebiros/226350
     */
    public static function mb_str_pad(string $input, int $pad_length, string $pad_string = ' ', int $pad_type = STR_PAD_RIGHT): string
    {
        $diff = strlen( $input ) - mb_strlen( $input );
        return str_pad( $input, $pad_length + $diff, $pad_string, $pad_type );
    }

    /**
     * get nth param from input array
     * @param iterable<IEntry> $inputs
     * @param int $position
     * @return string|null
     */
    public static function getNthParam(iterable $inputs, int $position = 1): ?string
    {
        $nthKey = Cli::UNSORTED_PARAM . $position;
        foreach ($inputs as $input) {
            /** @var IEntry $input */
            if ($input->getKey() == $nthKey) {
                return $input->getValue();
            }
        }
        return null;
    }

    public static function sanitizeClass(string $input): string
    {
        $input = strtr($input, [':' => '\\', '/' => '\\']);
        return ('\\' == $input[0]) ? mb_substr($input, 1) : $input ;
    }

    public static function getTaskCall(object $class): string
    {
        return strtr(get_class($class), '\\', '/');
    }
}

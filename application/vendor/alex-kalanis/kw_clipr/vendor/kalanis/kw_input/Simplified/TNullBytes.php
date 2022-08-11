<?php

namespace kalanis\kw_input\Simplified;


/**
 * Trait TNullBytes
 * @package kalanis\kw_input\Extras
 * Remove null bytes from string
 */
trait TNullBytes
{
    /**
     * @param string $string
     * @return string
     */
    public function removeNullBytes($string)
    {
        return str_replace(chr(0), '', $string);
    }
}

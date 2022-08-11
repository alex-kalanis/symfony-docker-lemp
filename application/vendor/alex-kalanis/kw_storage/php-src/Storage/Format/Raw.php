<?php

namespace kalanis\kw_storage\Storage\Format;


use kalanis\kw_storage\Interfaces\IFormat;


/**
 * Class Raw
 * @package kalanis\kw_storage\Storage\Format
 * No encoding/decoding made
 */
class Raw implements IFormat
{
    public function decode($content)
    {
        return $content;
    }

    public function encode($data)
    {
        return $data;
    }
}

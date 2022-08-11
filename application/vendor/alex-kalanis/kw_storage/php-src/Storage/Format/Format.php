<?php

namespace kalanis\kw_storage\Storage\Format;


use kalanis\kw_storage\Interfaces\IFormat;


/**
 * Class Format
 * @package kalanis\kw_storage\Storage\Format
 * Basic work with content to storage - let primitives stay, encode rest
 */
class Format implements IFormat
{
    public function decode($content)
    {
        if (is_numeric($content)) {
            return $content;
        }
        if (is_bool($content)) {
            return $content;
        }
        $encodeResult = json_decode(strval($content), true);
        if (is_null($encodeResult)) {
            // problems with decoding - return original string
            return $content;
        }
        return $encodeResult;
    }

    public function encode($data)
    {
        if (is_bool($data)) {
            return $data;
        }
        if (is_numeric($data)) {
            return $data;
        }
        if (is_string($data)) {
            return $data;
        }
        return strval(json_encode($data));
    }
}

<?php

namespace kalanis\kw_storage\Storage\Format;


use kalanis\kw_storage\Interfaces\IFormat;


/**
 * Class Serialized
 * @package kalanis\kw_storage\Storage\Format
 * Serialize content in storage
 */
class Serialized implements IFormat
{
    public function decode($content)
    {
        return unserialize(strval($content));
    }

    public function encode($data)
    {
        return serialize($data);
    }
}

<?php

namespace kalanis\kw_storage\Storage\Format;


use kalanis\kw_storage\Interfaces;


/**
 * Class Factory
 * @package kalanis\kw_storage\Storage\Format
 * Basic implementation of format factory - use just "not so stupid" check
 */
class Factory
{
    public function getFormat(Interfaces\IStorage $storage): Interfaces\IFormat
    {
        return new Format();
    }
}

<?php

namespace kalanis\kw_storage\Storage\Key;


use kalanis\kw_storage\Interfaces\IKey;


/**
 * Class DefaultKey
 * @package kalanis\kw_storage\Key
 * Change nothing - keys are valid as they are
 */
class DefaultKey implements IKey
{
    public function fromSharedKey(string $key): string
    {
        return $key;
    }
}

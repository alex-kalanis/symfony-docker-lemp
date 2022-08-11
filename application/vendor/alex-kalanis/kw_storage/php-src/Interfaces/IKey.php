<?php

namespace kalanis\kw_storage\Interfaces;


/**
 * Interface IKey
 * @package kalanis\kw_storage\Interfaces
 * Set rules for key change and apply them
 */
interface IKey
{
    /**
     * @param string $key what app think
     * @return string real key for storage
     */
    public function fromSharedKey(string $key): string;
}

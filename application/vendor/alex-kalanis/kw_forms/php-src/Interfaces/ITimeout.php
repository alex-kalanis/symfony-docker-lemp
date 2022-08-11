<?php

namespace kalanis\kw_forms\Interfaces;


/**
 * Interface ITimeout
 * @package kalanis\kw_forms\Interfaces
 *
 * Interface for info if the object can be used
 */
interface ITimeout
{
    /**
     * Can use?
     * @return bool
     */
    public function isRunning(): bool;

    /**
     * Update expiration
     */
    public function updateExpire(): void;
}

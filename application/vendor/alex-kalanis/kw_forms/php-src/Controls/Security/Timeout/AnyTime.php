<?php

namespace kalanis\kw_forms\Controls\Security\Timeout;


use kalanis\kw_forms\Interfaces\ITimeout;


/**
 * Class AnyTime
 * @package kalanis\kw_forms\Controls\Security\Timeout
 * Pass everytime, no rules triggered
 */
class AnyTime implements ITimeout
{
    public function updateExpire(): void
    {
    }

    public function isRunning(): bool
    {
        return true;
    }
}

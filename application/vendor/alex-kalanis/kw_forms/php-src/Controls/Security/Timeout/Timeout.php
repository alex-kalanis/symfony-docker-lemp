<?php

namespace kalanis\kw_forms\Controls\Security\Timeout;


use ArrayAccess;
use kalanis\kw_forms\Interfaces\ITimeout;


/**
 * Class Timeout
 * @package kalanis\kw_forms\Controls\Security\Timeout
 * Remember expiration and for a preset time set it as passing
 */
class Timeout implements ITimeout
{
    const CAPTCHA_TIME = 'captchaTime';

    /** @var ArrayAccess */
    protected $session = null;
    /** @var int When ends time of pass */
    protected $time = 0;
    /** @var int How log interval is preset after correct response */
    protected $timeout = 0;

    public function __construct(ArrayAccess &$session, int $timeout = 0)
    {
        $this->session = $session;
        $this->timeout = $timeout;
        $this->time = ($this->session->offsetExists(static::CAPTCHA_TIME))
            ? intval(strval($this->session->offsetGet(static::CAPTCHA_TIME)))
            : 0 ;
    }

    public function updateExpire(): void
    {
        $this->time = time() + $this->timeout; // when it begins
        $this->session->offsetSet(static::CAPTCHA_TIME, $this->time); // set into session
    }

    public function isRunning(): bool
    {
        return (0 < $this->timeLeft());
    }

    public function timeLeft(): int
    {
        return $this->time - time();
    }
}

<?php

namespace kalanis\kw_forms\Controls\Security\Csrf;


use ArrayAccess;
use kalanis\kw_forms\Interfaces\ICsrf;


/**
 * Class Simple
 * Secure forms by simple tokens
 * @package kalanis\kw_forms\Controls\Security\Csrf
 */
class Simple implements ICsrf
{
    /** @var ArrayAccess */
    protected $session = null;
    /** @var int */
    protected $expire = 3600;

    public function init(ArrayAccess &$session, int $expire = 3600): void
    {
        $this->session = $session;
        $this->expire = $expire;
    }

    public function removeToken(string $codeName): void
    {
        if ($this->session->offsetExists($codeName)) {
            $this->session->offsetUnset($codeName);
        }
    }

    public function getToken(string $codeName): string
    {
        if (!$this->session->offsetExists($codeName)) {
            $this->session->offsetSet($codeName, uniqid('csrf', true));
            $this->session->offsetSet($codeName . '_timer', time() + $this->expire);
        }
        return strval($this->session->offsetGet($codeName));
    }

    public function getExpire(): int
    {
        return $this->expire;
    }

    public function checkToken(string $token, string $codeName): bool
    {
        return $this->session->offsetExists($codeName)
                && $this->session->offsetExists($codeName . '_timer')
                && $this->session->offsetGet($codeName) == $token
                && $this->session->offsetGet($codeName . '_timer') > time()
                ;
    }
}

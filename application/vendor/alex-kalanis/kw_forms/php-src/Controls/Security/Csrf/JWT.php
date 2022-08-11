<?php

namespace kalanis\kw_forms\Controls\Security\Csrf;


use ArrayAccess;
use kalanis\kw_forms\Interfaces\ICsrf;
use kalanis\kw_forms\JWT\Token;


/**
 * Class JWT
 * Secure forms by JWT token
 * @package kalanis\kw_forms\Controls\Security\Csrf
 * @codeCoverageIgnore dependent on remote library
 */
class JWT implements ICsrf
{
    /** @var string */
    protected $sessionToken = '';

    /** @var int */
    protected $expire = 3600;

    /** @var array<string, string> Token cache */
    protected $tokens = [];

    public function init(ArrayAccess &$cookie, int $expire = 3600): void
    {
        if (empty($cookie['csrf_token'])) {
            $cookie['csrf_token'] = uniqid('csrf', true);
        }

        $this->sessionToken = strval($cookie['csrf_token']);
        $this->expire = $expire;
    }

    public function removeToken(string $codeName): void
    {
        unset($this->tokens[$codeName]);
    }

    public function getToken(string $codeName): string
    {
        if (!isset($this->tokens[$codeName])) {
            $this->tokens[$codeName] = Token::getJWTToken(['nam' => $codeName, 'ses' => $this->sessionToken], $this->expire);
        }
        return $this->tokens[$codeName];
    }

    public function getExpire(): int
    {
        return $this->expire;
    }

    public function checkToken(string $token, string $codeName): bool
    {
        $data = Token::decodeJWTToken($token);
        return isset($data['nam']) && isset($data['ses']) &&
            ($data['nam'] == $codeName) &&
            ($data['ses'] == $this->sessionToken);
    }
}

<?php

namespace kalanis\kw_forms\Interfaces;


use ArrayAccess;


/**
 * Interface ICsrf
 * @package kalanis\kw_forms\Interfaces
 * Check tokens for cross-site
 */
interface ICsrf
{
    /**
     * @param ArrayAccess $cookie
     * @param int         $expire
     */
    public function init(ArrayAccess &$cookie, int $expire = 3600): void;

    /**
     * Remove known token
     * @param string $codeName
     */
    public function removeToken(string $codeName): void;

    /**
     * Get token
     * @param string $codeName
     * @return string
     */
    public function getToken(string $codeName): string;

    /**
     * Check if token is valid
     * @param string $token
     * @param string $codeName
     * @return bool
     */
    public function checkToken(string $token, string $codeName): bool;

    /**
     * Get token expire time
     * @return int
     */
    public function getExpire(): int;
}

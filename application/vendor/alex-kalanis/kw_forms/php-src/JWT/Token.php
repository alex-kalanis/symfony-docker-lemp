<?php

namespace kalanis\kw_forms\JWT;


use Firebase\JWT\Key;

/**
 * Class Token
 * @package kalanis\kw_forms\JWT
 * Javascript Web Token - class for setting and make checks
 * @codeCoverageIgnore dependency on remote library
 */
class Token
{
    /** @var string */
    protected static $domain = '';
    /** @var string */
    protected static $privateKey = '';
    /** @var string */
    protected static $lastError = '';

    /**
     * Initialize library - set somewhere in bootstrap alongside the other configurations
     * @param string $privateKey
     * @param string $domain
     */
    public static function setInitials(string $privateKey, string $domain): void
    {
        static::$privateKey = $privateKey;
        static::$domain = $domain;
    }

    /**
     * Generate JWT token and user data
     *
     * @param array<string, string> $tokenData
     * @param int   $ttl
     * @return string
     */
    public static function getJWTToken(array $tokenData, int $ttl = 7200): string
    {
        $time = time();
        $tokenData['iss'] = static::$domain;
        $tokenData['iat'] = $time;
        $tokenData['exp'] = $time + $ttl;

        return \Firebase\JWT\JWT::encode($tokenData, static::$privateKey, 'HS256');
    }

    /**
     * @param string $token
     * @return array<string, string>
     */
    public static function decodeJWTToken(string $token): array
    {
        try {
            $decoded = (array) \Firebase\JWT\JWT::decode($token, new Key(static::$privateKey, 'HS256'));
            if (static::$domain != $decoded['iss']) {
                throw new \Exception('Token was not issued for this site.');
            }
        } catch (\Exception $ex) {
            static::$lastError = 'Token Error: ' . $ex->getMessage();
            $decoded = [];
        }

        return $decoded;
    }

    /**
     * @return string
     */
    public static function getLastError()
    {
        return static::$lastError;
    }
}

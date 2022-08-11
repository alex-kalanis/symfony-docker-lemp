<?php

namespace kalanis\kw_address_handler;


/**
 * Class Headers
 * @package kalanis\kw_address_handler
 * Working with headers
 */
class Headers
{
    /** @var array<int, string> */
    protected static $headerCodes = [
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        413 => '413 Payload Too Large',
        414 => '414 URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        429 => '429 Too Many Requests',
        451 => '451 Unavailable For Legal Reasons',
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported',
    ];

    /**
     * @param string $protocol
     * @param int $code
     * @codeCoverageIgnore access external
     */
    public static function setCustomCode(string $protocol, int $code): void
    {
        header($protocol . ' ' . static::codeToHeader($code));
    }

    /**
     * @param int $code
     * @param int $default
     * @return string
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    public static function codeToHeader(int $code, int $default = 404): string
    {
        return isset(static::$headerCodes[$code])
            ? static::$headerCodes[$code]
            : (isset(static::$headerCodes[$default])
                ? static::$headerCodes[$default]
                : static::$headerCodes[500]
            );
    }
}

<?php

namespace kalanis\kw_address_handler;


/**
 * Class Redirect
 * @package kalanis\kw_address_handler
 * Redirects in project
 * @codeCoverageIgnore access external call
 */
class Redirect
{
    const TARGET_MOVED = 301;
    const TARGET_FOUND = 302;
    const TARGET_TEMPORARY = 307;
    const TARGET_PERMANENT = 308;

    public function __construct(string $redirectTo, int $targetMethod = self::TARGET_MOVED, ?int $step = null)
    {
        if (0 !== strncmp('cli', PHP_SAPI, 3)) {
            if (true !== headers_sent()) {
                if (!is_null($step) && (0 !== $step)) {
                    header('Refresh:' . $step . ';url=' . $this->removeNullBytes($redirectTo));
                } else {
                    header('Location: ' . $this->removeNullBytes($redirectTo), true, $targetMethod);
                    exit(0);
                }
            }
        }
    }

    protected function removeNullBytes(string $string, string $nullTo = ''): string
    {
        return strval(str_replace(chr(0), $nullTo, $string));
    }
}

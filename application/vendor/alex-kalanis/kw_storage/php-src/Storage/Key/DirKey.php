<?php

namespace kalanis\kw_storage\Storage\Key;


use kalanis\kw_storage\Interfaces\IKey;


class DirKey implements IKey
{
    /** @var string */
    protected static $dir= '/var/cache/wwwcache/';

    public static function setDir(string $dir): void
    {
        static::$dir = $dir;
    }

    /**
     * @param string $key channel Id
     * @return string
     * /var/cache/wwwcache - coming from cache check
     */
    public function fromSharedKey(string $key): string
    {
        return static::$dir . $key;
    }
}

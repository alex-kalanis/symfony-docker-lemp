<?php

namespace kalanis\kw_storage;


/**
 * Class Helper
 * @package kalanis\kw_storage
 * Create cache with already known settings
 */
class Helper
{
    public static function initCache(): Storage
    {
        return new Storage(new Storage\Factory(
            new Storage\Target\Factory(),
            new Storage\Format\Factory(),
            new Storage\Key\Factory()
        ));
    }

    public static function initIntoStatic(): void
    {
        StaticCache::setStorage(static::initCache());
    }
}

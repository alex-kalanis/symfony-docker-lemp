<?php

namespace kalanis\kw_paths;


/**
 * Class Stored
 * @package kalanis\kw_paths
 * Stored path data through system runtime
 */
class Stored
{
    /** @var null|Path */
    protected static $paths = null;

    public static function init(Path $path): void
    {
        static::$paths = $path;
    }

    public static function getPath(): ?Path
    {
        return static::$paths ? clone static::$paths : null;
    }

    public static function getOriginalPath(): ?Path
    {
        return static::$paths;
    }
}

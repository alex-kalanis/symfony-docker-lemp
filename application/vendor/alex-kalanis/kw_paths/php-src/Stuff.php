<?php

namespace kalanis\kw_paths;


use kalanis\kw_paths\Interfaces\IPaths;


/**
 * Class Stuff
 * @package kalanis\kw_paths
 * Stuff helping parsing the paths
 * Do not use pathinfo(), because has problems with code pages
 */
class Stuff
{
    /**
     * Return path with no extra dots and slashes
     * Do not call realpath() which do the similar thing
     * @param string $path
     * @return string
     */
    public static function sanitize(string $path): string
    {
        return static::arrayToPath(array_filter(array_filter(static::pathToArray($path), ['\kalanis\kw_paths\Stuff', 'notDots'])));
    }

    public static function notDots(string $content): bool
    {
        return !in_array($content, ['.', '..']);
    }

    /**
     * @param string $path
     * @return string[]
     */
    public static function pathToArray(string $path): array
    {
        return explode(DIRECTORY_SEPARATOR, $path); // OS dependent
    }

    /**
     * @param string[] $path
     * @return string
     */
    public static function arrayToPath(array $path): string
    {
        return implode(DIRECTORY_SEPARATOR, $path); // OS dependent
    }

    /**
     * @param string $path
     * @return string[]
     */
    public static function linkToArray(string $path): array
    {
        return explode(IPaths::SPLITTER_SLASH, $path); // HTTP dependent
    }

    /**
     * @param string[] $path
     * @return string
     */
    public static function arrayToLink(array $path): string
    {
        return implode(IPaths::SPLITTER_SLASH, $path); // HTTP dependent
    }

    /**
     * Path to file (with trailing slash)
     * @param string $path
     * @return string
     * Do not use dirname(), because has problems with code pages
     */
    public static function directory(string $path): string
    {
        $pos = mb_strrpos($path, DIRECTORY_SEPARATOR);
        return (false !== $pos) ? mb_substr($path, 0, $pos + 1) : '' ;
    }

    /**
     * Name of file from the whole path
     * @param string $path
     * @return string
     * Do not use basename(), because has problems with code pages
     */
    public static function filename(string $path): string
    {
        $pos = mb_strrpos($path, DIRECTORY_SEPARATOR);
        return (false !== $pos) ? mb_substr($path, $pos + 1) : $path ;
    }

    /**
     * Base of file (part before the "dot")
     * @param string $path
     * @return string
     */
    public static function fileBase(string $path): string
    {
        $pos = mb_strrpos($path, IPaths::SPLITTER_DOT);
        return (false !== $pos) && (0 < $pos) ? mb_substr($path, 0, $pos) : $path ;
    }

    /**
     * Extension of file (part after the "dot" if it exists)
     * @param string $path
     * @return string
     */
    public static function fileExt(string $path): string
    {
        $pos = mb_strrpos($path, IPaths::SPLITTER_DOT);
        return ((false !== $pos) && (0 < $pos)) ? mb_substr($path, $pos + 1) : '' ;
    }

    /**
     * Remove ending slash
     * @param string $path
     * @return string
     */
    public static function removeEndingSlash(string $path): string
    {
        return (DIRECTORY_SEPARATOR == mb_substr($path, -1, 1)) ? mb_substr($path, 0, -1) : $path ;
    }

    /**
     * Return correct name with no non-ascii characters
     * @param string $name
     * @param int $maxLen
     * @return string
     */
    public static function canonize(string $name, int $maxLen = 127): string
    {
        $fName = preg_replace('/((&[[:alpha:]]{1,6};)|(&#[[:alnum:]]{1,7};))/', '', $name); // remove ascii-escaped chars
        $fName = preg_replace('/[^[:alnum:]_\s\-\.]/', '', strval($fName)); // remove non-alnum + dots
        $fName = preg_replace('/[\s]/', '_', strval($fName)); // whitespaces to underscore
        $fName = strval($fName);
        $ext = static::fileExt($fName);
        $base = static::fileBase($fName);
        $extLen = strlen($ext);
        $cut = substr($base, 0, ($maxLen - $extLen));
        return ($extLen) ? $cut . IPaths::SPLITTER_DOT . $ext : $cut ;
    }
}

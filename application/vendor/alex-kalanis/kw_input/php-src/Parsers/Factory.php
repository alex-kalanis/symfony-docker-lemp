<?php

namespace kalanis\kw_input\Parsers;


use kalanis\kw_input\Interfaces\IEntry;


/**
 * Class Factory
 * @package kalanis\kw_input\Loaders
 * Loading factory
 */
class Factory
{
    /** @var AParser[] */
    protected static $loaders;

    public function getLoader(string $source): AParser
    {
        if (isset(static::$loaders[$source])) {
            return static::$loaders[$source];
        }
        $loader = $this->select($source);
        static::$loaders[$source] = $loader;
        return $loader;
    }

    protected function select(string $source): AParser
    {
        switch ($source) {
            case IEntry::SOURCE_CLI:
                return new Cli();
            case IEntry::SOURCE_FILES:
                return new Files();
            default:
                return new Basic();
        }
    }
}

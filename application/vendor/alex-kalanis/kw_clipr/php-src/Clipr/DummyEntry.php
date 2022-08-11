<?php

namespace kalanis\kw_clipr\Clipr;


use kalanis\kw_input\Entries\Entry;


/**
 * Class DummyEntry
 * @package kalanis\kw_clipr\Clipr
 * Entry for testing content in tasks - make simple array of these to set testing input data
 */
class DummyEntry extends Entry
{
    /**
     * @param string $key
     * @param mixed|null $value
     * @param string $source
     * @return DummyEntry
     */
    public static function init(string $key, $value, string $source = self::SOURCE_EXTERNAL): self
    {
        $lib = new self();
        $lib->setEntry($source, $key, $value);
        return $lib;
    }
}

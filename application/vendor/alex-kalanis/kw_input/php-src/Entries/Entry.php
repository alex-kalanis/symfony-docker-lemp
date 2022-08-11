<?php

namespace kalanis\kw_input\Entries;


use kalanis\kw_input\Interfaces;


/**
 * Class Entry
 * @package kalanis\kw_input\Entries
 * Simple entry from source
 * For setting numeric value just re-type set by strval()
 * For setting boolean value just expand previous - strval(intval())
 */
class Entry implements Interfaces\IEntry
{
    /** @var string */
    protected $key = '';
    /** @var mixed|null */
    protected $value = '';
    /** @var string */
    protected $source = '';

    /** @var string[] */
    protected static $availableSources = [
        self::SOURCE_CLI,
        self::SOURCE_GET,
        self::SOURCE_POST,
        // self::SOURCE_FILES, // has own class
        self::SOURCE_COOKIE,
        self::SOURCE_SESSION,
        self::SOURCE_SERVER,
        self::SOURCE_ENV,
        self::SOURCE_EXTERNAL,
    ];

    /**
     * @param string $source
     * @param string $key
     * @param mixed|null $value
     * @return Entry
     */
    public function setEntry(string $source, string $key, $value = null): self
    {
        $this->key = $key;
        $this->value = $value;
        $this->source = $this->availableSource($source);
        return $this;
    }

    protected function availableSource(string $source): string
    {
        return in_array($source, static::$availableSources) ? $source : $this->source;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return strval($this->getValue());
    }
}

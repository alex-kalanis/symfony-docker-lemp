<?php

namespace kalanis\kw_input\Filtered;


use ArrayAccess;
use kalanis\kw_input\Entries\Entry;
use kalanis\kw_input\Input;
use kalanis\kw_input\Interfaces;


/**
 * Class SimpleArrays
 * @package kalanis\kw_input\Filtered
 * Helping class for passing info from simple arrays into objects
 */
class SimpleArrays implements Interfaces\IFiltered
{
    /** @var array<int|string, string|int|float|bool|null> */
    protected $inputs = [];
    /** @var string */
    protected $source = '';

    /**
     * @param array<int|string, string|int|float|bool|null> $inputs
     * @param string $source
     */
    public function __construct(array $inputs, string $source = Interfaces\IEntry::SOURCE_EXTERNAL)
    {
        $this->inputs = $inputs;
        $this->source = $source;
    }

    public function getInObject(?string $entryKey = null, array $entrySources = []): ArrayAccess
    {
        return new Input($this->getInArray($entryKey, $entrySources));
    }

    public function getInArray(?string $entryKey = null, array $entrySources = []): array
    {
        $result = [];
        foreach ($this->inputs as $key => $value) {
            if (is_null($entryKey) || ($key === $entryKey)) {
                $entry = new Entry();
                $entry->setEntry($this->source, strval($key), $value);
                $result[strval($key)] = $entry;
            }
        }
        return $result;
    }
}

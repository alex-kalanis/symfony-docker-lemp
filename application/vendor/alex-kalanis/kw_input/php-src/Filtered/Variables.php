<?php

namespace kalanis\kw_input\Filtered;


use ArrayAccess;
use kalanis\kw_input\Input;
use kalanis\kw_input\Interfaces;


/**
 * Class Variables
 * @package kalanis\kw_input\Filtered
 * Helping class for passing info from inputs into objects
 */
class Variables implements Interfaces\IFiltered
{
    /** @var Interfaces\IInputs */
    protected $inputs = null;

    public function __construct(Interfaces\IInputs $inputs)
    {
        $this->inputs = $inputs;
    }

    public function getInObject(?string $entryKey = null, array $entrySources = []): ArrayAccess
    {
        return new Input($this->getInArray($entryKey, $entrySources));
    }

    public function getInArray(?string $entryKey = null, array $entrySources = []): array
    {
        return $this->intoKeyObjectArray($this->inputs->getIn($entryKey, $entrySources));
    }

    /**
     * @param iterable<Interfaces\IEntry> $entries
     * @return array<int|string, Interfaces\IEntry>
     */
    protected function intoKeyObjectArray(iterable $entries): array
    {
        $result = [];
        foreach ($entries as $entry) {
            /** @var Interfaces\IEntry $entry */
            $result[$entry->getKey()] = $entry;
        }
        return $result;
    }
}

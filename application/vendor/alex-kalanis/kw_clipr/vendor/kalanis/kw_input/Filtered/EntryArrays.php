<?php

namespace kalanis\kw_input\Filtered;


use ArrayAccess;
use kalanis\kw_input\Input;
use kalanis\kw_input\Interfaces;


/**
 * Class EntryArrays
 * @package kalanis\kw_input\Filtered
 * Helping class for passing info from entry arrays into objects
 */
class EntryArrays implements Interfaces\IFiltered
{
    /** @var array<int|string, Interfaces\IEntry> */
    protected $inputs = [];

    /**
     * @param array<int|string, Interfaces\IEntry> $inputs
     */
    public function __construct(array $inputs)
    {
        $this->inputs = $inputs;
    }

    public function getInObject(?string $entryKey = null, array $entrySources = []): ArrayAccess
    {
        return new Input($this->getInArray($entryKey, $entrySources));
    }

    public function getInArray(?string $entryKey = null, array $entrySources = []): array
    {
        $result = [];
        foreach ($this->inputs as $input) {
            /** @var Interfaces\IEntry $input */
            $passSource = $passKey = false;
            if (empty($entrySources) || in_array($input->getSource(), $entrySources)) {
                $passSource = true;
            }
            if (is_null($entryKey) || ($input->getKey() === $entryKey)) {
                $passKey = true;
            }
            if ($passSource && $passKey) {
                $result[$input->getKey()] = $input;
            }
        }
        return $result;
    }
}

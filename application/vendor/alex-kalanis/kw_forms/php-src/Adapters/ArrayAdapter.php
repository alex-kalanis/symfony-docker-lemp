<?php

namespace kalanis\kw_forms\Adapters;


use kalanis\kw_input\Interfaces\IEntry;


/**
 * Class ArrayAdapter
 * @package kalanis\kw_forms\Adapters
 */
class ArrayAdapter extends AAdapter
{
    /** @var array<int|string, string|int|float|null> */
    protected $inputs = null;
    /** @var string */
    protected $inputType = IEntry::SOURCE_GET;

    /**
     * @param array<int|string, string|int|float|null> $inputs
     */
    public function __construct(array $inputs)
    {
        $this->inputs = $inputs;
    }

    public function loadEntries(string $inputType): void
    {
        $result = [];
        foreach ($this->inputs as $postedKey => &$posted) {
            $result[$this->removeNullBytes(strval($postedKey))] = $this->removeNullBytes(strval($posted));
        }
        $this->vars = $result;
        $this->inputType = $inputType;
    }

    public function getSource(): string
    {
        return $this->inputType;
    }
}

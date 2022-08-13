<?php

namespace kalanis\kw_forms\Adapters;


use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_input\Interfaces\IEntry;
use kalanis\kw_input\Interfaces\IFiltered;


/**
 * Class InputFilesAdapter
 * @package kalanis\kw_forms\Adapters
 */
class InputFilesAdapter extends FilesAdapter
{
    /** @var IFiltered */
    protected $inputs = null;

    public function __construct(IFiltered $inputs)
    {
        $this->inputs = $inputs;
    }

    public function loadEntries(string $inputType): void
    {
        $this->vars = $this->inputs->getInArray(null, [IEntry::SOURCE_FILES]);
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        if ($this->valid()) {
            return $this->offsetGet($this->key);
        }
        throw new FormsException(sprintf('Unknown offset %s', $this->key));
    }
}

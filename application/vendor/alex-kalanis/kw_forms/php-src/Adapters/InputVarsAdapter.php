<?php

namespace kalanis\kw_forms\Adapters;


use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_input\Interfaces\IEntry;
use kalanis\kw_input\Interfaces\IFiltered;


/**
 * Class InputVarsAdapter
 * @package kalanis\kw_forms\Adapters
 */
class InputVarsAdapter extends VarsAdapter
{
    /** @var IFiltered */
    protected $inputs = null;

    public function __construct(IFiltered $inputs)
    {
        $this->inputs = $inputs;
    }

    public function loadEntries(string $inputType): void
    {
        if (IEntry::SOURCE_POST == $inputType) {
            $this->vars = $this->inputs->getInArray(null, [IEntry::SOURCE_POST]);
        } elseif (IEntry::SOURCE_GET == $inputType) {
            $this->vars = $this->inputs->getInArray(null, [IEntry::SOURCE_GET]);
        } elseif (IEntry::SOURCE_CLI == $inputType) {
            $this->vars = $this->inputs->getInArray(null, [IEntry::SOURCE_CLI]);
        } else {
            throw new FormsException(sprintf('Unknown input type - %s', $inputType));
        }
        $this->inputType = $inputType;
    }

    /**
     * @throws FormsException
     * @return mixed|string|null
     */
    public function getValue()
    {
        return $this->current()->getValue();
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

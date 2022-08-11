<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class TSelected
 * @package kalanis\kw_forms\Controls
 * Render input for select's option
 */
trait TSelected
{
    /**
     * @param string|int|float|bool|null $value
     */
    public function setValue($value): void
    {
        if ($this->originalValue == $value) {
            $this->setSelected($value);
        } else {
            $this->setSelected('none');
        }
    }

    public function getValue()
    {
        return $this->getSelected() ? $this->originalValue : '' ;
    }

    /**
     * Set if option is selected
     * @param string|int|float|bool|null $value
     * @return $this
     */
    protected function setSelected($value): self
    {
        if (!empty($value) && ('none' !== strval($value))) {
            $this->setAttribute('selected', 'selected');
        } else {
            $this->removeAttribute('selected');
        }
        return $this;
    }

    /**
     * Get if option is selected
     * @return bool
     */
    protected function getSelected(): bool
    {
        return ('selected' == $this->getAttribute('selected'));
    }

    abstract public function setAttribute(string $name, string $value): void;

    abstract public function removeAttribute(string $name): void;

    abstract public function getAttribute(string $name): ?string;
}

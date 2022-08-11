<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class TMultiple
 * @package kalanis\kw_forms\Controls
 * Render input for selecting multiple inputs by select
 */
trait TMultiple
{
    /**
     * Set if select has multiple values to get
     * @param string $value
     */
    public function setMultiple($value): void
    {
        if (!empty($value) && ('none' !== strval($value))) {
            $this->setAttribute('multiple', 'multiple');
            if (!$this->getAttribute('size')) {
                $this->setSize(count($this->children));
            }
        } else {
            $this->removeAttribute('multiple');
        }
    }

    /**
     * Set displayed size
     * 1 or less for drop menu
     * 2 or more for list
     * @param int $value
     */
    public function setSize(int $value): void
    {
        $this->setAttribute('size', strval($value));
    }

    /**
     * Get if select could get multiple values
     * @return bool
     */
    public function getMultiple(): bool
    {
        return ('multiple' == $this->getAttribute('multiple'));
    }

    abstract public function setAttribute(string $name, string $value): void;

    abstract public function removeAttribute(string $name): void;

    abstract public function getAttribute(string $name): ?string;
}

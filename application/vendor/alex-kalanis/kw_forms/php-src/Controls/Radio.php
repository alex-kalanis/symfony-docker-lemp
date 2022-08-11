<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Interfaces\IOriginalValue;


/**
 * Class Radio
 * @package kalanis\kw_forms\Controls
 * Render input for selecting by radio checkbox
 */
class Radio extends AControl implements IOriginalValue
{
    use TChecked;

    public $templateInput = '<input type="radio" value="%1$s"%2$s />';

    /**3
     * @param string $alias
     * @param string|int|float|null $value
     * @param string $label
     * @param string $checked
     * @return $this
     */
    public function set(string $alias, $value = null, string $label = '', $checked = ''): self
    {
        $this->setEntry($alias, $value, $label);
        $this->setChecked($checked);
        $this->setAttribute('id', $this->getKey());
        return $this;
    }

    protected function fillTemplate(): string
    {
        return '%2$s %1$s';
    }

    public function getOriginalValue()
    {
        return $this->originalValue;
    }

    public function renderInput($attributes = null): string
    {
        $this->fillParent();
        $this->addAttributes($attributes);
        if (!($this->parent instanceof RadioSet)) {
            $this->setAttribute('name', $this->getKey());
        }
        return $this->wrapIt(sprintf($this->templateInput, $this->escaped(strval($this->getOriginalValue())), $this->renderAttributes(), $this->renderChildren()), $this->wrappersInput);
    }

    public function renderLabel($attributes = []): string
    {
        $this->fillParent();
        return parent::renderLabel($attributes);
    }

    protected function fillParent(): void
    {
        if ($this->parent instanceof RadioSet) {
            $this->setAttribute('name', strval($this->parent->getAttribute('name')));
            $this->setAttribute('id', $this->parent->getKey() . '_' . strval($this->getOriginalValue()));
        }
    }
}

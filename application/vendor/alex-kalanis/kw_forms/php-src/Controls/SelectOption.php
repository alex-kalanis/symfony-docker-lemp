<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Interfaces\IOriginalValue;


/**
 * Class SelectOption
 * @package kalanis\kw_forms\Controls
 * Form element for selection - single option line
 */
class SelectOption extends AControl implements IOriginalValue
{
    use TSelected;

    protected $templateLabel = '';
    protected $templateInput = '<option value="%1$s"%2$s>%3$s</option>';

    public function getOriginalValue()
    {
        return $this->originalValue;
    }

    public function renderLabel($attributes = []): string
    {
        return '';
    }

    public function renderInput($attributes = null): string
    {
        return $this->wrapIt(sprintf($this->templateInput, $this->escaped(strval($this->originalValue)), $this->renderAttributes(), $this->escaped(strval($this->getLabel()))), $this->wrappersInput);
    }

    public function renderErrors($errors): string
    {
        return '';
    }
}

<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class Submit
 * @package kalanis\kw_forms\Controls
 * Form element for submit button
 */
class Submit extends Button
{
    protected $templateInput = '<input type="submit" value="%1$s"%2$s />';
    protected $originalValue = 'submit';

    /**
     * Check if form was sent by this button
     * @var boolean
     */
    protected $submitted = false;

    public function setValue($value): void
    {
        $this->submitted = !empty($value);
    }

    public function getValue()
    {
        return $this->submitted ? $this->originalValue : '' ;
    }

    public function setTitle(string $title): void
    {
        $this->originalValue = $title;
    }

    public function renderInput($attributes = null): string
    {
        $this->addAttributes($attributes);
        $this->setAttribute('name', $this->getKey());
        return $this->wrapIt(sprintf($this->templateInput, strval($this->originalValue), $this->renderAttributes(), $this->renderChildren()), $this->wrappersInput);
    }
}

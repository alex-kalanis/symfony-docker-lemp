<?php

namespace kalanis\kw_forms\Controls;


class DatePicker extends AControl
{
    protected $templateInput = '<input type="text" value="%1$s"%2$s />%3$s';
    /** @var string */
    protected $dateFormat = 'Y-m-d';
    /** @var string */
    protected $dateClass = 'datepicker';

    public function set(string $alias, ?string $originalValue = null, string $label = ''): self
    {
        $this->setEntry($alias, $originalValue, $label);
        $this->setAttribute('class', $this->dateClass);
        $this->setAttribute('id', $this->getKey());
        return $this;
    }

    public function setDateFormat(string $dateFormat): self
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    public function setValue($value): void
    {
        if (is_numeric($value)) {
            $this->value = $value;
        } elseif (!empty($value)) {
            $this->value = strtotime(strval($value));
        }
    }

    public function renderInput($attributes = null): string
    {
        $this->addAttributes($attributes);
        if (is_numeric($this->value)) {
            $value = date($this->getDateFormat(), intval($this->value));
        } else {
            $value = '';
        }
        $this->setAttribute('name', $this->getKey());
        return $this->wrapIt(sprintf($this->templateInput, $this->escaped(strval($value)), $this->renderAttributes(), $this->renderChildren()), $this->wrappersInput);
    }
}

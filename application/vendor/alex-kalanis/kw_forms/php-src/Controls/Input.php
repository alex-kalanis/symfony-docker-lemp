<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class Input
 * @package kalanis\kw_forms\Controls
 * Create simple form element
 * HTML5 input types (search, number, email, url, range, color, date, datetime, datetime-local, month, week, time, tel)
 * Default type="text". Set type example: $this->addAttributes(['type' => 'range'])
*/
class Input extends AControl
{
    protected $templateInput = '<input value="%1$s"%2$s />%3$s';

    public function set(string $type, string $alias, ?string $value = null, string $label = ''): self
    {
        $this->setEntry($alias, $value, $label);
        $this->setAttribute('type', $type);
        $this->setAttribute('id', $this->getKey());
        return $this;
    }
}

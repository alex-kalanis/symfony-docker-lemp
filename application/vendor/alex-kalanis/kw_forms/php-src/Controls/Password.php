<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class Password
 * @package kalanis\kw_forms\Controls
 * Form element for password
 */
class Password extends AControl
{
    public $templateInput = '<input type="password" value=""%2$s />';

    public function set(string $alias, string $label = ''): self
    {
        $this->setEntry($alias, null, $label);
        $this->setAttribute('id', $this->getKey());
        return $this;
    }
}

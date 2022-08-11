<?php

namespace kalanis\kw_forms\Controls;


/**
 * Wrapper trait for form labels
 * @author Petr Plsek
 * @author Adam Dornak
 */
trait TLabel
{
    /** @var string|null */
    protected $label = null;

    /**
     * 1 id(for=""), 2 labelText,  3 attributes
     * @var string
     */
    protected $templateLabel = '<label for="%1$s"%3$s>%2$s</label>';

    /**
     * Set object label
     * @param string $value
     */
    public function setLabel(?string $value): void
    {
        $this->label = $value;
    }

    /**
     * Returns object label
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }
}

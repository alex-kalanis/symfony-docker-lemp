<?php

namespace kalanis\kw_forms\Controls;


/**
 * Trait TValue
 * @package kalanis\kw_forms\Controls
 */
trait TValue
{
    /** @var string|int|float|bool|null */
    protected $value = '';

    /**
     * @param string|int|float|bool|null $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return string|int|float|bool|null
     */
    public function getValue()
    {
        return $this->value;
    }
}

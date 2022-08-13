<?php

namespace kalanis\kw_forms\Form;


use kalanis\kw_input\Interfaces\IEntry;


/**
 * Trait TMethod
 * @package kalanis\kw_forms\Form
 * Trait to processing methods of form
 */
trait TMethod
{
    /**
     * Set transfer method of form
     * @param string $param
     */
    public function setMethod(string $param): void
    {
        if (in_array($param, [IEntry::SOURCE_GET, IEntry::SOURCE_POST, IEntry::SOURCE_CLI])) {
            $this->setAttribute('method', $param);
        }
    }

    /**
     * Get that method
     * @return string
     */
    public function getMethod(): string
    {
        return strval($this->getAttribute('method'));
    }

    abstract public function setAttribute(string $name, string $value): void;

    abstract public function removeAttribute(string $name): void;

    abstract public function getAttribute(string $name): ?string;
}

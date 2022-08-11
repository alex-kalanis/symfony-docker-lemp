<?php

namespace kalanis\kw_templates\Interfaces;


/**
 * Interface IAttributes
 * @package kalanis\kw_templates\Interfaces
 * Contains constants used across the project which cannot be defined in traits
 */
interface IAttributes
{
    const ATTR_NAME_CLASS = 'class';
    const ATTR_SEP_CLASS = ' ';
    const ATTR_NAME_STYLE = 'style';
    const ATTR_SEP_STYLE = ';';
    const ATTR_SET_STYLE = ':';

    /**
     * Add array of attributes into current object attributes
     * @param string|array<string, string|int|array<string>>|null $attributes
     */
    public function addAttributes($attributes): void;

    /**
     * Set attributes, leave nothing from previous ones
     * @param string|array<string, string|int|array<string>>|null $attributes
     */
    public function setAttributes($attributes): void;

    /**
     * Get all available attributes
     * @return array<string, string>
     */
    public function getAttributes(): array;
}

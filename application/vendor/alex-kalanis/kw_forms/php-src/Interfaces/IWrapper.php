<?php

namespace kalanis\kw_forms\Interfaces;


use kalanis\kw_templates\Interfaces\IHtmlElement;


/**
 * Interface IWrapper
 * @package kalanis\kw_forms\Interfaces
 * What can be accessed by wrappers
 */
interface IWrapper extends ITemplateError
{
    /**
     * Add wrapper for the whole object ( in render() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapper($wrapper, array $attributes = []): void;

    /**
     * Add wrapper for each child ( in renderChild() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapperChild($wrapper, array $attributes = []): void;

    /**
     * Add wrapper for labels ( in renderLabel() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapperLabel($wrapper, array $attributes = []): void;

    /**
     * Add wrapper for inputs ( in renderInput() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapperInput($wrapper, array $attributes = []): void;

    /**
     * Add wrapper for children content ( int renderChildren() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapperChildren($wrapper, array $attributes = []): void;

    /**
     * Add wrapper for error message content ( in renderErrors() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapperError($wrapper, array $attributes = []): void;

    /**
     * Add wrapper for error message content ( in renderErrors() method )
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     */
    public function addWrapperErrors($wrapper, array $attributes = []): void;
}

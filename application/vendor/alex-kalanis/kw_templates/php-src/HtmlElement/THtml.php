<?php

namespace kalanis\kw_templates\HtmlElement;


/**
 * Trait THtml
 * @package kalanis\kw_templates\Template
 * Trait for describe internal content of element, usually HTML code
 * Extend child of AHtmlElement
 * @author Adam Dornak original
 * @author Petr Plsek refactored
 */
trait THtml
{
    /** @var string */
    protected $innerHtml = '';

    /**
     * Set internal content of element
     * @param string $value
     */
    public function addInnerHTML(string $value): void
    {
        $this->innerHtml = $value;
    }

    /**
     * Get internal content of element
     * @return string
     */
    public function getInnerHTML(): string
    {
        return $this->innerHtml;
    }
}

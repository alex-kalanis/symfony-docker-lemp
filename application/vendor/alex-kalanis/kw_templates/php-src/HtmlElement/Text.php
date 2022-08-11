<?php

namespace kalanis\kw_templates\HtmlElement;


use kalanis\kw_templates\AHtmlElement;


/**
 * Class Text
 * @package kalanis\kw_templates\Template
 * Set text as simple HTML element
 */
class Text extends AHtmlElement
{
    use THtml;

    public function __construct(string $value, ?string $alias = null)
    {
        $this->alias = $alias;
        $this->addInnerHTML($value);
    }

    public function render(): string
    {
        return $this->getInnerHTML();
    }
}

<?php

namespace kalanis\kw_templates\HtmlElement;


use kalanis\kw_templates\Interfaces\IHtmlElement;


/**
 * Trait TParent
 * @package kalanis\kw_templates\Template
 * Trait for work with parenting of html elements
 * Extend child of AHtmlElement
 * @author Adam Dornak original
 * @author Petr Plsek refactored
 */
trait TParent
{
    /** @var IHtmlElement|null */
    protected $parent;

    /**
     * Set parent element
     * @param IHtmlElement|null $parent
     */
    public function setParent(?IHtmlElement $parent = null): void
    {
        $this->parent = $parent;
        $this->afterParentSet();
    }

    /**
     * Returns parent element
     * @return IHtmlElement|null
     */
    public function getParent(): ?IHtmlElement
    {
        return $this->parent;
    }

    /**
     * Change element settings after new parent has been set
     */
    protected function afterParentSet(): void
    {
    }

    /**
     * Add $element after current one - if there is any parent
     * @param IHtmlElement|string $element
     * @param string $alias
     */
    public function append($element, ?string $alias = null): void
    {
        if ($this->parent instanceof IHtmlElement) {
            $this->parent->addChild($element, $alias);
        }
    }
}

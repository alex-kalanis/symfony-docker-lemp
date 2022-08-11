<?php

namespace kalanis\kw_templates\Interfaces;


use Countable, Traversable;


/**
 * Interface IHtmlElement
 * @package kalanis\kw_templates\Interfaces
 * Base of each html element
 */
interface IHtmlElement extends IAttributes, Countable
{
    /**
     * Returns object alias
     * @return string|null
     */
    public function getAlias(): ?string;

    /**
     * Render element
     * @return string
     */
    public function render(): string;

    /**
     * Add child on stack end or replace the current one (if they have same alias)
     * @param IHtmlElement|string $child
     * @param string|null $alias - key for lookup; beware of empty strings
     * @param bool $merge merge with original element if already exists
     * @param bool $inherit inherit properties from current element
     */
    public function addChild($child, $alias = null, bool $merge = false, bool $inherit = false): void;

    /**
     * Merge this element with child and its attributes
     * @param IHtmlElement $child
     */
    public function merge(IHtmlElement $child): void;

    /**
     * Remove child by key
     * @param string|int $childAlias
     */
    public function removeChild($childAlias): void;

    /**
     * Return last child
     * @return IHtmlElement|null
     */
    public function lastChild(): ?IHtmlElement;

    /**
     * Set children of element
     * @param iterable|string[]|IHtmlElement[] $children
     */
    public function setChildren(iterable $children = []): void;

    /**
     * Return all children as iterator
     * @return Traversable<IHtmlElement>
     */
    public function getChildren(): Traversable;
}

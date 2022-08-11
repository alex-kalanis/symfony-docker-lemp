<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class SelectOptgroup
 * @package kalanis\kw_forms\Controls
 * Form element for selection - option group
 */
class SelectOptgroup extends AControl
{
    /** @var int */
    private static $uniqid = 0;
    protected $templateLabel = '';
    protected $templateInput = '<optgroup label="%1$s">%3$s</optgroup>';

    /**
     * Create element Optgroup
     * @param string $alias
     * @param string $label
     * @param iterable<string|int, string|SelectOption> $children
     * @return $this
     */
    public function set(string $alias, string $label = '', iterable $children = [])
    {
        $this->setEntry(sprintf('%s_%s', $alias, self::$uniqid), '', $label);
        foreach ($children as $childAlias => $child) {
            if ($child instanceof SelectOption) {
                $this->addChild($child, $childAlias);
            } else {
                $this->addOption(strval($childAlias), $childAlias, strval($child));
            }
        }
        self::$uniqid++;
        return $this;
    }

    /**
     * @param string $alias
     * @param string|int|float|bool|null $value
     * @param string $label
     * @return SelectOption
     */
    public function addOption(string $alias, $value, string $label = ''): SelectOption
    {
        $option = new SelectOption();
        $option->setEntry($alias, $value, $label);
        $this->addChild($option, $alias);
        return $option;
    }

    public function setValue($value): void
    {
        foreach ($this->children as $child) {
            if ($child instanceof SelectOption) {
                $child->setValue($value);
            }
        }
    }

    public function getValue()
    {
        foreach ($this->children as $child) {
            if ($child instanceof SelectOption) {
                if (!empty($child->getValue())) {
                    return $child->getValue();
                }
            }
        }
        return '';
    }

    public function renderInput($attributes = null): string
    {
        return $this->wrapIt(sprintf($this->templateInput, $this->escaped(strval($this->getLabel())), $this->renderAttributes(), $this->renderChildren()), $this->wrappersInput);
    }

    public function renderErrors($errors): string
    {
        return '';
    }
}

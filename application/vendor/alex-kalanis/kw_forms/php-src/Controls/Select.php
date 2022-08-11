<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class Select
 * @package kalanis\kw_forms\Controls
 * Form element for selection - dropdown menu
 */
class Select extends AControl
{
    protected $templateInput = '<select %2$s>%3$s</select>';

    /**
     * Create element of form entry Select
     * @param string $alias
     * @param string|int|float|null $value
     * @param string $label
     * @param iterable<string, string|int|float|SelectOptgroup|SelectOption|iterable<string, string|SelectOption>> $children
     * @return $this
     */
    public function set(string $alias, $value = null, string $label = '', iterable $children = [])
    {
        // transfer child values arrays to option group or single entries into options
        foreach ($children as $childAlias => $child) {
            if (is_iterable($child)) {
                $this->addGroup(strval($childAlias), $child, strval($childAlias));
            } elseif ($child instanceof SelectOptgroup) {
                $this->addChild($child, $childAlias);
            } elseif ($child instanceof SelectOption) {
                $this->addChild($child, $childAlias);
            } else {
                $this->addOption(strval($childAlias), $childAlias, strval($child));
            }
        }
        $this->setEntry($alias, '', $label);
        $this->setValue($value);
        $this->setAttribute('id', $this->getKey());
        return $this;
    }

    /**
     * Add group into select
     * @param string $alias
     * @param iterable<string, string|SelectOption> $values
     * @param string $label
     * @return SelectOptgroup
     */
    public function addGroup(string $alias, iterable $values, string $label = '')
    {
        $options = new SelectOptgroup();
        $options->set($alias, $label, $values);
        $this->addChild($options, $alias);
        return $options;
    }

    /**
     * Add simple option into select
     * @param string $alias
     * @param string $value
     * @param string $label
     * @return SelectOption
     */
    public function addOption(string $alias, $value, string $label = '')
    {
        $option = new SelectOption();
        $option->setEntry($alias, $value, $label);
        $this->addChild($option, $alias);
        return $option;
    }

    public function getValue()
    {
        foreach ($this->children as $child) {
            if ($child instanceof AControl) {
                $returnValues = $child->getValue();
                if (!empty($returnValues)) {
                    return $returnValues;
                }
            }
        }
        return '';
    }

    public function setValue($value): void
    {
        foreach ($this->children as $child) {
            if ($child instanceof AControl) {
                $child->setValue($value);
            }
        }
    }
}

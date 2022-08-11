<?php

namespace kalanis\kw_forms\Controls;


/**
 * RadioSet definition - add group of radios into your form
 *
 * <b>Usage:</b>
 * <code>
 * $radio1 = new Controls\Radio();
 * $radio1->set(0, 'yes', 'NO');
 * $radios[] = $radio1;
 * $radio2 = new Controls\Radio();
 * $radio2->set(1, 'no', 'YES');
 * $radios[] = $radio2;
 *
 * $radio = new Controls\RadioSet();
 * $radio->set('alias', 1, null, $radios);
 * echo $radio->getValue() // no
 *
 * $form->addRadios('accessKey')->addOption(111, 'yes')->addOption(222, 'no');
 *
 */
class RadioSet extends AControl
{
    protected $templateInput = '%3$s';

    /**
     * Add group of elements of form entries Radio
     * @param string $key
     * @param string|int|float|null $value
     * @param string $label
     * @param iterable<string, string|int|Radio> $children
     * @return $this
     */
    public function set(string $key, $value = null, string $label = '', iterable $children = [])
    {
        $this->setEntry($key, '', $label);
        foreach ($children as $alias => $child) {
            if ($child instanceof Radio) {
                $child->setParent($this);
                $this->addChild($child);
            } elseif (is_string($child)) {
                $this->addOption($key, $alias, $child, strval(intval(strval($value) == $alias)));
            }
        }
        return $this;
    }

    /**
     * Add radio option into current set
     * @param string $alias
     * @param string $value
     * @param string $label
     * @param string $selected
     * @return $this
     */
    public function addOption(string $alias, $value, string $label = '', string $selected = '')
    {
        $radio = new Radio();
        $this->addChild($radio->set($alias, $value, $label, $selected));
        return $this;
    }

    /**
     * Set checked for selected alias; rest will be unchecked
     * @param string|int|float|bool|null $value
     */
    public function setValue($value): void
    {
        foreach ($this->children as $child) {
            if ($child instanceof Radio) {
                $child->setValue($child->getOriginalValue() == strval($value));
            }
        }
    }

    /**
     * Returns value of selected radio from set
     * @return string|int|float|bool|null
     */
    public function getValue()
    {
        foreach ($this->children as $child) {
            if (($child instanceof Radio) && $child->getValue()) {
                return $child->getOriginalValue();
            }
        }
        return '';
    }
}

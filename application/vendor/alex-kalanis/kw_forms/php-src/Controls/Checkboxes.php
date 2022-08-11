<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_forms\Interfaces\IMultiValue;


/**
 * Definition of form controls Group of Checkboxes
 *
 * <b>Examples</b>
 * <code>
 * // render form for set 2 values, second will be empty
 * $form = new Form();
 * $checkboxes = $form->addCheckboxes('fotos', 'Choose files');
 * $checkboxes->addCheckbox('file1', 'File 1'));
 * $checkboxes->addCheckbox('file2', 'File 2', true));
 * echo $form;
 *
 * // render form for setting 5 values, first two will be set
 * $form = new Form();
 * for($i=1;$i<6;$i++) {
 *     $files[] = $form->getControlFactory()->getCheckbox('', 1, 'File '.$i);
 * }
 * $checkboxes = $form->addCheckboxes('fotos', 'Select files', ['0', 1], $files);
 * echo $form;
 * </code>
 */
class Checkboxes extends AControl implements IMultiValue
{
    use TShorterKey;

    public $templateLabel = '<label>%2$s</label>';
    public $templateInput = '%3$s';

    /**
     * Create group of form elements Checkbox
     * @param string $alias
     * @param array<string, string|int|float|bool> $value
     * @param string|null $label
     * @param iterable<string, string|Checkbox> $children
     * @return $this
     */
    public function set(string $alias, array $value = [], ?string $label = null, iterable $children = array())
    {
        $this->alias = $alias;
        $this->setLabel($label);

        foreach ($children as $childLabel => $childValue) {
            if ($childValue instanceof Checkbox) {
                $this->addChild($childValue, $childLabel);
            } else {
                $this->addCheckbox(strval($childLabel), strval($childValue), $childValue);
            }
        }

        if (!empty($value)) {
            $this->setValues($value);
        }
        return $this;
    }

    /**
     * Create single Checkbox element
     * @param string $alias
     * @param string $label
     * @param string $value
     * @param boolean $checked
     * @return Checkbox
     */
    public function addCheckbox(string $alias, string $label, $value, $checked = null)
    {
        $checkbox = new Checkbox();
        $checkbox->set($alias, $value, $label);
        $checkbox->setValue(strval($checked));
        $this->addChild($checkbox);
        return $checkbox;
    }

    /**
     * Get statuses of all children
     * @return array<string, string|int|float|bool|null>
     */
    public function getValues(): array
    {
        $array = array();
        foreach ($this->children as $child) {
            if ($child instanceof Checkbox) {
                $array[$child->getKey()] = $child->getValue();
            }
        }
        return $array;
    }

    /**
     * Set values to all children
     * !! UNDEFINED values will be SET too !!
     * @param array<string, string|int|float|bool|null> $array
     */
    public function setValues(array $array = []): void
    {
        foreach ($this->children as $child) {
            if ($child instanceof Checkbox) {
                $shortKey = $this->shorterKey($child->getKey());
                $child->setValue(
                isset($array[$shortKey])
                    ? $array[$shortKey]
                    : (
                    isset($array[$child->getKey()])
                        // @codeCoverageIgnoreStart
                        ? $array[$child->getKey()] // dunno how to test now, probably directly with "foo[bar]" variable
                        // @codeCoverageIgnoreEnd
                        : ''
                    )
                );
            }
        }
    }

    public function renderInput($attributes = null): string
    {
        return $this->wrapIt(sprintf($this->templateInput, '', '', $this->renderChildren()), $this->wrappersInput);
    }

    /**
     * Render all children, add missing prefixes
     * @throws RenderException
     * @return string
     */
    public function renderChildren(): string
    {
        $return = '';
        foreach ($this->children as $child) {
            if ($child instanceof AControl) {
                $child->setAttribute('id', $this->getAlias() . '_' . $child->getKey());
            }

            $return .= $this->wrapIt($child->render(), $this->wrappersChild) . PHP_EOL;
        }
        return $this->wrapIt($return, $this->wrappersChildren);
    }
}

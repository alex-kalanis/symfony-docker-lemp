<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_forms\Interfaces;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_templates\Interfaces\IHtmlElement;


/**
 * Trait TSubControls
 * @package kalanis\kw_forms\Controls
 * Trait for rendering other controls
 */
trait TSubControls
{
    /** @var array<string, AControl> */
    protected $controls = [];

    public function addControl(string $key, AControl $control): void
    {
        $this->controls[$key] = $control;
    }

    public function getControl(string $key): ?AControl
    {
        foreach ($this->controls as &$control) {
            if ($control instanceof Interfaces\IContainsControls && $control->/** @scrutinizer ignore-call */hasControl($key)) {
                return $control->/** @scrutinizer ignore-call */getControl($key);
            } elseif ($control instanceof AControl) {
                if ($control->getKey() == $key) {
                    return $control;
                }
            }
        }
        return null;
    }

    /**
     * Get values of all children
     * @return array<string, string|int|float|bool|null>
     */
    public function getValues(): array
    {
        $array = [];
        foreach ($this->controls as &$control) {
            /** @var AControl $control */
            if ($control instanceof Interfaces\IMultiValue) {
                $array += $control->/** @scrutinizer ignore-call */getValues();
            } else {
                $array[$control->/** @scrutinizer ignore-call */getKey()] = $control->/** @scrutinizer ignore-call */getValue();
            }
        }
        return $array;
    }

    /**
     * Set values to all children, !!undefined values will NOT be set!!
     * <b>Usage</b>
     * <code>
     *  $form->setValues($this->context->post) // set values from Post
     *  $form->setValues($mapperObject) // set values from other source
     * </code>
     * @param array<string, string|int|float|bool|null> $data
     */
    public function setValues(array $data = []): void
    {
        foreach ($this->controls as &$control) {
            /** @var AControl $control */
            if ($control instanceof Interfaces\IMultiValue) {
                $control->/** @scrutinizer ignore-call */setValues($data);
            } else {
                if (isset($data[$control->getKey()])) {
                    $control->setValue($data[$control->getKey()]);
                }
            }
        }
    }

    /**
     * Get labels of all children
     * @return array<string, string|null>
     */
    public function getLabels(): array
    {
        $array = [];
        foreach ($this->controls as &$control) {
            /** @var AControl $control */
            if ($control instanceof Interfaces\IContainsControls) {
                $array += $control->/** @scrutinizer ignore-call */getLabels();
            } else {
                $array[$control->getKey()] = $control->getLabel();
            }
        }
        return $array;
    }

    /**
     * Set labels to all children
     * @param array<string, string|null> $array
     */
    public function setLabels(array $array = []): void
    {
        foreach ($this->controls as &$control) {
            /** @var AControl $control */
            if ($control instanceof Interfaces\IContainsControls) {
                $control->/** @scrutinizer ignore-call */setLabels($array);
            } elseif (isset($array[$control->getKey()])) {
                $control->setLabel($array[$control->getKey()]);
            }
        }
    }

    /**
     * @param array<string, array<int, RuleException>> $passedErrors
     * @param array<string|IHtmlElement> $wrappersError
     * @throws RenderException
     * @return array<string, string>
     */
    public function getErrors(array $passedErrors, array $wrappersError): array
    {
        $returnErrors = [];
        foreach ($this->controls as &$child) {
            if ($child instanceof Interfaces\IContainsControls) {
                $returnErrors += $child->/** @scrutinizer ignore-call */getErrors($passedErrors, $wrappersError);
            } elseif ($child instanceof AControl) {
                if (isset($passedErrors[$child->getKey()])) {
                    if (!$child->wrappersErrors()) {
                        $child->addWrapperErrors($wrappersError);
                    }
                    $returnErrors[$child->getKey()] = $child->renderErrors($passedErrors[$child->getKey()]);
                }
            }
        }

        return $returnErrors;
    }

    public function count(): int
    {
        return count($this->controls);
    }
}

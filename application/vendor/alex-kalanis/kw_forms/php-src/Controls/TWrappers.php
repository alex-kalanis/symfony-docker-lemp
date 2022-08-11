<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_templates\HtmlElement;
use kalanis\kw_templates\Interfaces\IHtmlElement;


/**
 * Wrapper trait for form inputs
 * @author Petr Plsek
 * @author Adam Dornak
 * @author Petr Bolehovsky
 */
trait TWrappers
{
    use TTemplateError;

    /** @var IHtmlElement[] */
    protected $wrappers = [];
    /** @var IHtmlElement[] */
    protected $wrappersLabel = [];
    /** @var IHtmlElement[] */
    protected $wrappersInput = [];
    /** @var IHtmlElement[] */
    protected $wrappersChild = [];
    /** @var IHtmlElement[] */
    protected $wrappersChildren = [];
    /** @var IHtmlElement[] */
    protected $wrappersError = [];
    /** @var IHtmlElement[] */
    protected $wrappersErrors = [];
    /** @var string */
    protected $errorMustBeAnInstance = 'Wrapper must be an instance of IHtmlElement or array of its instances';

    /**
     * Pack string into preset html element
     * @param string $string
     * @param IHtmlElement|IHtmlElement[] $wrappers
     * @throws RenderException
     * @return string
     */
    protected function wrapIt(string $string, $wrappers): string
    {
        $return = $string;
        if (is_array($wrappers)) {
            foreach ($wrappers as $wrapper) {
                $return = $this->wrapIt($return, $wrapper);
            }
        } elseif ($wrappers instanceof IHtmlElement) {
            $wrappers->addChild($return);
            $return = $wrappers->render();
        } else {
            throw new RenderException($this->errorMustBeAnInstance);
        }

        return $return;
    }

    /**
     * Add wrapper into predefined stack
     * @param IHtmlElement[] $stack
     * @param IHtmlElement|IHtmlElement[]|string|string[] $wrapper
     * @param array<string, string> $attributes
     */
    protected function addWrapperToStack(&$stack, $wrapper, array $attributes = []): void
    {
        if (is_array($wrapper)) {
            foreach ($wrapper as $_wrapper) {
                $this->addWrapperToStack($stack, $_wrapper);
            }
        } else {
            if (!($wrapper instanceof IHtmlElement)) {
                $wrapper = HtmlElement::init($wrapper, $attributes);
            } elseif (!empty($attributes)) {
                $wrapper->setAttributes($attributes);
            }
            if (!in_array($wrapper, $stack)) {
                $stack[] = $wrapper;
            }
        }
    }

    /**
     * Add wrapper for the whole object
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::render
     */
    public function addWrapper($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappers, $wrapper, $attributes);
    }

    /**
     * Add wrapper for each child
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::renderChild
     */
    public function addWrapperChild($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappersChild, $wrapper, $attributes);
    }

    /**
     * Add wrapper for labels
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::renderLabel
     */
    public function addWrapperLabel($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappersLabel, $wrapper, $attributes);
    }

    /**
     * Add wrapper for inputs
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::renderInput
     */
    public function addWrapperInput($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappersInput, $wrapper, $attributes);
    }

    /**
     * Add wrapper for content of children
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::renderChildren
     */
    public function addWrapperChildren($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappersChildren, $wrapper, $attributes);
    }

    /**
     * Add wrapper for error messages
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::renderErrors
     */
    public function addWrapperError($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappersError, $wrapper, $attributes);
    }

    /**
     * Add wrapper for error messages
     * @param string|string[]|IHtmlElement|IHtmlElement[] $wrapper
     * @param array<string, string> $attributes
     * @see AControl::renderErrors
     */
    public function addWrapperErrors($wrapper, array $attributes = []): void
    {
        $this->addWrapperToStack($this->wrappersErrors, $wrapper, $attributes);
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappers(): array
    {
        return $this->wrappers;
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappersLabel(): array
    {
        return $this->wrappersLabel;
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappersInput(): array
    {
        return $this->wrappersInput;
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappersChild(): array
    {
        return $this->wrappersChild;
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappersChildren(): array
    {
        return $this->wrappersChildren;
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappersError(): array
    {
        return $this->wrappersError;
    }

    /**
     * @return IHtmlElement[]
     */
    public function wrappersErrors(): array
    {
        return $this->wrappersErrors;
    }

    public function resetWrappers(): void
    {
        $this->wrappers = [];
        $this->wrappersLabel = [];
        $this->wrappersInput = [];
        $this->wrappersChild = [];
        $this->wrappersChildren = [];
        $this->wrappersError = [];
        $this->wrappersErrors = [];
    }
}

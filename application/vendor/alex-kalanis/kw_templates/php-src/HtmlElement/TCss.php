<?php

namespace kalanis\kw_templates\HtmlElement;


use kalanis\kw_templates\Interfaces\IAttributes;


/**
 * Trait TCss
 * @package kalanis\kw_templates\Template
 * Trait for work with cascade style sheets - via classes
 * Extend child of AHtmlElement
 * @author Adam Dornak original
 * @author Petr Plsek refactored
 */
trait TCss
{
    /**
     * Add class into attribute class
     * @param string $name
     */
    public function addClass(string $name): void
    {
        $class = $this->getAttribute(IAttributes::ATTR_NAME_CLASS);
        if (!empty($class)) {
            $class = explode(IAttributes::ATTR_SEP_CLASS, $class);
            if (!in_array($name, $class)) {
                $class[] = $name;
                $this->setAttribute(IAttributes::ATTR_NAME_CLASS, implode(IAttributes::ATTR_SEP_CLASS, $class));
            }
        } else {
            $this->setAttribute(IAttributes::ATTR_NAME_CLASS, $name);
        }
    }

    /**
     * Remote class from attribute class
     * @param string $name
     */
    public function removeClass(string $name): void
    {
        $class = $this->getAttribute(IAttributes::ATTR_NAME_CLASS);
        if (!empty ($class)) {
            $class = explode(IAttributes::ATTR_SEP_CLASS, $class);
            if (in_array($name, $class)) {
                $class = array_flip($class);
                unset ($class[$name]);
                $class = array_flip($class);
                $this->setAttribute(IAttributes::ATTR_NAME_CLASS, implode(IAttributes::ATTR_SEP_CLASS, $class));
            }
        }
    }

    abstract public function getAttribute(string $name): ?string;

    abstract public function setAttribute(string $name, string $value): void;
}

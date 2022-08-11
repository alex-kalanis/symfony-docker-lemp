<?php

namespace kalanis\kw_templates\HtmlElement;


use kalanis\kw_templates\Interfaces\IAttributes;


/**
 * Trait TStyles
 * @package kalanis\kw_templates\Template
 * Trait for work with cascade style sheets - direct access to styles
 * Extend child of AHtmlElement
 * @author Adam Dornak original
 * @author Petr Plsek refactored
 */
trait TStyles
{
    public function addCss(string $name, string $value): void
    {
        $attrStyle = $this->readCss();
        $attrStyle[$name] = $value;
        $this->updateCss($attrStyle);
    }

    public function getCss(string $name): string
    {
        $attrStyle = $this->readCss();
        return $attrStyle[$name];
    }

    public function removeCss(string $name): void
    {
        $attrStyle = $this->readCss();
        if (isset($attrStyle[$name])) {
            unset($attrStyle[$name]);
        }
        $this->updateCss($attrStyle);
    }

    /**
     * @return array<string, string>
     */
    private function readCss(): array
    {
        $attrStyle = $this->getAttribute(IAttributes::ATTR_NAME_STYLE);
        $parts = explode(IAttributes::ATTR_SEP_STYLE, strval($attrStyle));

        $styles = [];
        foreach ($parts as $part) {
            if ($part && false !== strpos($part, IAttributes::ATTR_SET_STYLE)) {
                list($key, $val) = explode(IAttributes::ATTR_SET_STYLE, $part, 2);
                $styles[trim($key)] = trim($val);
            }
        }
        return $styles;
    }

    /**
     * @param array<string, string> $attrStyle
     */
    private function updateCss(array $attrStyle): void
    {
        $style = '';
        foreach ($attrStyle as $key => $val) {
            $style .= $key . IAttributes::ATTR_SET_STYLE . $val . IAttributes::ATTR_SEP_STYLE;
        }
        $this->setAttribute(IAttributes::ATTR_NAME_STYLE, $style);
    }

    abstract public function getAttribute(string $name): ?string;

    abstract public function setAttribute(string $name, string $value): void;
}

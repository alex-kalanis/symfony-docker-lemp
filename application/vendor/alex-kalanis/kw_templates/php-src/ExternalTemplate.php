<?php

namespace kalanis\kw_templates;


/**
 * Class ExternalTemplate
 * @package kalanis\kw_templates
 * Load external source as template
 */
abstract class ExternalTemplate extends ATemplate
{
    protected function loadTemplate(): string
    {
        return '';
    }

    public function setTemplate(string $content): ATemplate
    {
        return parent::setTemplate($content);
    }
}

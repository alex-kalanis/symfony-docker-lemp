<?php

namespace kalanis\kw_forms\Interfaces;


/**
 * Interface ITemplateError
 * @package kalanis\kw_forms\Interfaces
 * What can be accessed for mark error in template
 */
interface ITemplateError
{
    public function getTemplateError(): string;

    public function setTemplateError(string $templateError): void;
}

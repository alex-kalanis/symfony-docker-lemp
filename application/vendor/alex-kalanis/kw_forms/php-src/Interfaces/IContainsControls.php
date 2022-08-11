<?php

namespace kalanis\kw_forms\Interfaces;


use kalanis\kw_forms\Controls\AControl;
use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Validate;
use kalanis\kw_templates\Interfaces\IHtmlElement;


/**
 * Interface IContainsControls
 * @package kalanis\kw_forms\Interfaces
 * When control itself contains other controls
 */
interface IContainsControls extends IMultiValue
{
    public function hasControl(string $key): bool;

    public function getControl(string $key): ?AControl;

    /**
     * @return array<string, string|null>
     */
    public function getLabels(): array;

    /**
     * @param array<string, string|null> $array
     */
    public function setLabels(array $array = []): void;

    /**
     * @param array<string, array<int, RuleException>> $passedErrors
     * @param array<string|IHtmlElement> $wrappersError
     * @throws RenderException
     * @return array<string, string>
     */
    public function getErrors(array $passedErrors, array $wrappersError): array;

    /**
     * @param Validate $validate
     * @return bool
     */
    public function validateControls(Validate $validate): bool;

    /**
     * @return array<string, array<int, RuleException>>
     */
    public function getValidatedErrors(): array;
}

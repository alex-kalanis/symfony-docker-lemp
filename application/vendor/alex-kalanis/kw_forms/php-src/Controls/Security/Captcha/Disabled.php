<?php

namespace kalanis\kw_forms\Controls\Security\Captcha;


/**
 * Define no captcha to render
 */
class Disabled extends ACaptcha
{
    public function addRule(/** @scrutinizer ignore-unused */ string $ruleName, /** @scrutinizer ignore-unused */ string $errorText, /** @scrutinizer ignore-unused */ ...$args): void
    {
        // no additional rules applicable
    }

    public function getRules(): array
    {
        return [];
    }

    public function renderInput($attributes = null): string
    {
        return '';
    }

    public function renderLabel($attributes = array()): string
    {
        return  '';
    }

    public function renderErrors($errors): string
    {
        return '';
    }
}

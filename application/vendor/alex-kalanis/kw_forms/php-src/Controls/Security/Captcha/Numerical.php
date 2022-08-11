<?php

namespace kalanis\kw_forms\Controls\Security\Captcha;


use ArrayAccess;
use kalanis\kw_rules\Interfaces\IRules;


/**
 * Class Numerical
 * @package kalanis\kw_forms\Controls\Security\Captcha
 * Numerical operation solving captcha
 */
class Numerical extends AGraphical
{
    public function set(string $alias, ArrayAccess &$session, string $errorMessage, string $font = '/usr/share/fonts/truetype/freefont/FreeMono.ttf'): AGraphical
    {
        $this->font = $font;

        $num1 = mt_rand(0, 9);
        $num2 = mt_rand(0, 9);
        $text = ' ' . $num1 . ' + ' . $num2 . ' =';

        $this->setEntry($alias, null, $text);
        $this->fillSession($alias, $session, strval($num1 + $num2));
        $this->setAttribute('id', $this->getKey());
        parent::addRule(IRules::SATISFIES_CALLBACK, $errorMessage, [$this, 'checkFillCaptcha']);
        return $this;
    }

    public function addRule(/** @scrutinizer ignore-unused */ string $ruleName, /** @scrutinizer ignore-unused */ string $errorText, /** @scrutinizer ignore-unused */ ...$args): void
    {
        // no additional rules applicable
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function checkFillCaptcha($value): bool
    {
        $formName = $this->getKey() . '_last';
        return $this->session->offsetExists($formName) && (intval($this->session->offsetGet($formName)) == intval($value));
    }

    public function renderLabel($attributes = null): string
    {
        return '';
    }

    public function renderInput($attributes = null): string
    {
        return parent::renderLabel() . ' '. parent::renderInput($attributes);
    }
}

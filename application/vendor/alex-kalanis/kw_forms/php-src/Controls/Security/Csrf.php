<?php

namespace kalanis\kw_forms\Controls\Security;


use ArrayAccess;
use kalanis\kw_forms\Controls\Hidden;
use kalanis\kw_forms\Interfaces\ICsrf;
use kalanis\kw_rules\Interfaces\IRules;


/**
 * Class Csrf
 * @package kalanis\kw_forms\Controls\Security
 * Hidden entry which adds CSRF check
 * Must be child of hidden due necessity of pre-setting position in render
 * This one set another value to compare, on the other way multisend sets nothing
 */
class Csrf extends Hidden
{
    /** @var ICsrf */
    protected $csrf = null;
    /** @var string */
    protected $csrfTokenAlias = '';

    public function __construct()
    {
        $this->csrf = $this->getCsrfLib();
    }

    /**
     * @return ICsrf
     * @codeCoverageIgnore link adapter remote resource
     */
    protected function getCsrfLib(): ICsrf
    {
        return new Csrf\JWT();
    }

    public function setHidden(string $alias, ArrayAccess &$cookie, string $errorMessage): self
    {
        $this->csrf->init($cookie);
        $this->setEntry($alias);
        $this->csrfTokenAlias = "{$alias}SubmitCheck";
        $this->setValue($this->csrf->getToken($this->csrfTokenAlias));
        parent::addRule(IRules::SATISFIES_CALLBACK, $errorMessage, [$this, 'checkToken']);
        return $this;
    }

    /**
     * @param mixed $incomingValue
     * @return bool
     */
    public function checkToken($incomingValue): bool
    {
        if ($this->csrf->checkToken(strval($incomingValue), $this->csrfTokenAlias)) {
            // token reload
            $this->csrf->removeToken($this->csrfTokenAlias);
            $this->setValue($this->csrf->getToken($this->csrfTokenAlias));
            return true;
        } else {
            return false;
        }
    }

    public function addRule(/** @scrutinizer ignore-unused */ string $ruleName, /** @scrutinizer ignore-unused */ string $errorText, /** @scrutinizer ignore-unused */ ...$args): void
    {
        // no additional rules applicable
    }

    public function addRules(/** @scrutinizer ignore-unused */ iterable $rules = []): void
    {
        // no rules add applicable
    }

    public function removeRules(): void
    {
        // no rules removal applicable
    }

    public function renderErrors($errors): string
    {
        return '';
    }
}

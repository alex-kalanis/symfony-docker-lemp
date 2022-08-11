<?php

namespace kalanis\kw_forms\Controls\Security\Captcha;


use kalanis\kw_forms\Controls\AControl;
use kalanis\kw_forms\Interfaces\ITimeout;


/**
 * Class ACaptcha
 * @package kalanis\kw_forms\Controls\Security\Captcha
 * Class that define any Captcha
 * You can also pass captcha by preset timer
 */
abstract class ACaptcha extends AControl
{
    /** @var ITimeout|null */
    protected $libTimeout = null;

    public function addRules(/** @scrutinizer ignore-unused */ iterable $rules = []): void
    {
        // no adding external rules applicable
    }

    public function getRules(): array
    {
        $ruleset = $this->canPass() ? [] : $this->rules;
        if (($this->libTimeout instanceof ITimeout) && !empty($ruleset)) {
            $this->libTimeout->updateExpire();
        }
        return $ruleset;
    }

    public function removeRules(): void
    {
        // no rules removal applicable
    }

    public function renderLabel($attributes = []): string
    {
        return $this->canPass() ? '' : parent::renderLabel($attributes);
    }

    public function renderInput($attributes = []): string
    {
        return $this->canPass() ? '' : parent::renderInput($attributes);
    }

    public function renderErrors($errors): string
    {
        return $this->canPass() ? '' : parent::renderErrors($errors);
    }

    protected function canPass(): bool
    {
        return ($this->libTimeout instanceof ITimeout && $this->libTimeout->isRunning());
    }

    public function setTimeout(?ITimeout $libTimeout = null): self
    {
        $this->libTimeout = $libTimeout;
        return $this;
    }
}

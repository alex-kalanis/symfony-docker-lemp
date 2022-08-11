<?php

namespace kalanis\kw_forms\Controls\Security\Captcha;


use ArrayAccess;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Interfaces\ITimeout;


/**
 * Class Factory
 * @package kalanis\kw_forms\Controls\Security\Captcha
 * Select captcha for displaying and processing (mobile, PC)
 * Valid captcha can return true even after a little time (not need to draw it again)
 */
class Factory
{
    const TYPE_DISABLED = 1;
    const TYPE_TEXT = 2;
    const TYPE_MATH = 3;
    const TYPE_COLOUR = 4;
    const TYPE_NOCAPTCHA = 5;

    /** @var ITimeout|null */
    protected $libTimeout = null;
    /** @var string */
    protected $captchaError = 'The CAPTCHA wasn\'t entered correctly. Please try it again.';

    public function __construct(ITimeout $libTimeout = null, string $captchaError = '')
    {
        $this->libTimeout = $libTimeout;
        $this->captchaError = empty($captchaError) ? $this->captchaError : $captchaError ;
    }

    public function getCaptcha(int $type, ArrayAccess &$session, string $alias = 'captcha'): ACaptcha
    {
        switch ($type) {
            case static::TYPE_DISABLED:
                $captcha = new Controls\Security\Captcha\Disabled();
                $captcha->setEntry($alias);
                $captcha->setTimeout($this->libTimeout);
                return $captcha;
            case static::TYPE_TEXT:
                $captcha = new Controls\Security\Captcha\Text();
                $captcha->set($alias, $session, $this->captchaError);
                $captcha->setTimeout($this->libTimeout);
                return $captcha;
            case static::TYPE_MATH:
                $captcha = new Controls\Security\Captcha\Numerical();
                $captcha->set($alias, $session, $this->captchaError);
                $captcha->setTimeout($this->libTimeout);
                return $captcha;
            case static::TYPE_COLOUR:
                $captcha = new Controls\Security\Captcha\ColourfulText();
                $captcha->set($alias, $session, $this->captchaError);
                $captcha->setTimeout($this->libTimeout);
                return $captcha;
            case static::TYPE_NOCAPTCHA:
                $captcha = new Controls\Security\Captcha\NoCaptcha();
                $captcha->set($alias, $this->captchaError);
                $captcha->setTimeout($this->libTimeout);
                return $captcha;
            default:
                $captcha = new Controls\Security\Captcha\Text();
                $captcha->set($alias, $session, $this->captchaError);
                $captcha->setTimeout($this->libTimeout);
                return $captcha;
        }
    }
}

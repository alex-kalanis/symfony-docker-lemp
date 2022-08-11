<?php

namespace kalanis\kw_forms\Controls\Security\Captcha;


use ArrayAccess;
use kalanis\kw_forms\Exceptions\RenderException;


/**
 * Class AGraphical
 * @package kalanis\kw_forms\Controls\Security\Captcha
 * Graphical captcha
 */
abstract class AGraphical extends ACaptcha
{
    protected $templateLabel = '<img src="data:image/png;base64,%2$s" id="%1$s" alt="You need to solve this." />';
    protected $templateInput = '<input type="text" value=""%2$s />';
    /** @var string */
    protected $font = '';
    /** @var string */
    protected $renderError = 'Cannot render captcha image!';
    /** @var ArrayAccess */
    protected $session = null;

    protected function fillSession(string $alias, ArrayAccess &$session, string $text): void
    {
        $stringNow = $alias . '_now';
        $stringLast = $alias . '_last';

        $session->offsetSet($stringLast, ($session->offsetExists($stringNow) ? $session->offsetGet($stringNow) : null));
        $session->offsetSet($stringNow, $text);
        $this->session = & $session;
    }

    /**
     * Render label on form control
     * @param string|array<string, string> $attributes
     * @throws RenderException
     * @return string
     */
    public function renderLabel($attributes = array()): string
    {
        if ($this->canPass()) {
            return '';
        }
        return $this->wrapIt(sprintf($this->templateLabel, $this->getAttribute('id'), $this->getImage(strval($this->getLabel())), $this->renderAttributes($attributes)), $this->wrappersLabel);
    }

    /**
     * @param string $text
     * @throws RenderException
     * @return string
     */
    protected function getImage(string $text): string
    {
        $im = imagecreatetruecolor(160, 25);

        if (false === $im) {
            // @codeCoverageIgnoreStart
            // problems with gd library
            throw new RenderException($this->renderError);
        }
        // @codeCoverageIgnoreEnd

        $white = intval(imagecolorallocate($im, 255, 255, 255));
        $grey = intval(imagecolorallocate($im, 169, 169, 169));
        $black = intval(imagecolorallocate($im, 0, 0, 0));
        imagefilledrectangle($im, 0, 0, 160, 25, $white);

        imagettftext($im, 20, 0, 9, 19, $black, $this->font, $text);
        imagettftext($im, 20, 0, 11, 21, $black, $this->font, $text);
        imagettftext($im, 20, 0, 10, 20, $black, $this->font, $text);

        for ($i = 0; 3 > $i; $i++) {
            imageline($im, 0, $i * 10, 400, $i * 10, $grey);
        }

        for ($i = 0; 16 > $i; $i++) {
            imageline($im, $i * 10, 0, $i * 10, 30, $grey);
        }

        ob_start();
        imagepng($im);
        $img = strval(ob_get_contents());
        ob_end_clean();

        imagedestroy($im);

        return $img;
    }

    /**
     * Generate and returns random string with combination of numbers and chars with specified length
     * @param int $stringLength
     * @return string
     */
    protected function generateRandomString(int $stringLength = 16): string
    {
        $all = ['1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f','g','h','i',
            'j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','!','$','%'];
        $string = '';
        for ($i = 0; $i < $stringLength; $i++) {
            $rand = mt_rand(0, count($all) - 1);
            $string .= $all[$rand];
        }
//print_r(['CPT_>'=>$string]);
        return $string;
    }
}

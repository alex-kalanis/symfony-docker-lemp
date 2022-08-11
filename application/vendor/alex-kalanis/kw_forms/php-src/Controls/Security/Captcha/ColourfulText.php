<?php

namespace kalanis\kw_forms\Controls\Security\Captcha;


use ArrayAccess;
use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_rules\Interfaces\IRules;


/**
 * Class ColourfulText
 * @package kalanis\kw_forms\Controls\Security\Captcha
 * "Colourful" fill variant of captcha
 */
class ColourfulText extends AGraphical
{
    public function set(string $alias, ArrayAccess &$session, string $errorMessage, string $font = '/usr/share/fonts/truetype/freefont/freesans.ttf'): AGraphical
    {
        $this->font = $font;
        $text = $this->generateRandomString(6);

        $this->setEntry($alias, null, $text);
        $this->fillSession($alias, $session, $text);
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
        return $this->session->offsetExists($formName) && (strval($this->session->offsetGet($formName)) == strval($value));
    }

    protected function getImage(string $text): string
    {
        $width = 200;
        $height = 100;
        $image = @imagecreate($width, $height);
        if (false === $image) {
            // @codeCoverageIgnoreStart
            // problems with gd library
            throw new RenderException($this->renderError);
        }
        // @codeCoverageIgnoreEnd

        # Set the background and the text color of the CAPTCHA image using the imagecolorallocate PHP function:
        # set the captcha image  -  text will be white rendered on black
        # we don't random here to be sure that the text is visible
//        $bg_color = intval(imagecolorallocate($image, 255, 255, 255));
        $captcha_color = intval(imagecolorallocate($image, 150, 0, 150));
        # The resulting CAPTCHA image will include some generated lines, dots, and rectangles.
        # But before that, you generate random colors for it, using the imagecolorallocate function:
        # backstage colors  -  lines, dots and rectangles
        $line_color = intval(imagecolorallocate($image, mt_rand(0, 255), 0, 255));
        $dots_color = intval(imagecolorallocate($image, mt_rand(0, 255), 255, mt_rand(0, 255)));
        $rect_color = intval(imagecolorallocate($image, 0, mt_rand(50, 127), 50));
        # Add some "security" marks. For this, you will draw with random colors some dots, rectangles,
        # and lines in the background of the CAPTCHA to make sure that a robot application can not identify
        # and extract the CAPTCHA text (in addition, the text is rendered with different sizes and fonts,
        # and at different coordinates). To generate random dots for the background of the CAPTCHA image,
        # you use the imagefilledellipse PHP function with random x and y coordinates for the center, width,
        # and height. The x coordinate of the center will be a number between 0 and the width of the ellipse;
        # the y coordinate of the center is a number between 0 and the height of the ellipse. The width and
        # height of the ellipse are random numbers between 0 and 3, for obtaining ellipses with dot aspect.
        # generate random dots
        for ($i = 0; $i < ($width * $height); $i++) {
            imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0,3), mt_rand(0,3), $dots_color);
        }
        # To generate random lines using the imageline PHP function, randomly generate the lengths and the
        # coordinates of the lines as in the below code:
        # generate random lines
        for ($i=0; $i < ($width + $height) / 3; $i++) {
            imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $line_color);
        }
        # To generate random rectangles using the imagerectangle PHP function, randomly generate the sizes
        # of the rectangles as in the below code:
        # generate random rectangles
        for ($i=0; $i < ($width + $height) / 3; $i++) {
            imagerectangle($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $rect_color);
        }
        # Create a bounding box of text using TrueType fonts. To do that, you can use the imagettfbbox PHP function:
        # create bounding box in pixels for a TrueType text
        $tb = imagettfbbox($height * 0.40, 0, $this->font, $text);
        if (false === $tb) {
            // @codeCoverageIgnoreStart
            throw new RenderException($this->renderError);
        }
        // @codeCoverageIgnoreEnd

        # The most important step is writing the generated text on top of the generated image using the TrueType
        # font. For this, you need the imagettftext PHP function.
        $urcX = ($width - $tb[4])/2; # tb[4] = upper right corner, X position
        $urcY = ($height - $tb[5])/2; # tb[5] = upper right corner, Y position
        # write the given text into the image using TrueType font
        imagettftext($image, mt_rand(intval($height * 0.30), intval($height * 0.40)), 0, $urcX, $urcY, $captcha_color, $this->font, $text);
        # For a nice design, you can go further and apply image filters. For example, you can apply
        # IMG_FILTER_NEGATE and IMG_FILTER_SMOOTH PHP predefined image filters using the imagefilter PHP function:
        #apply two image filters
        //  imagefilter($image,IMG_FILTER_NEGATE);
        //  imagefilter($image,IMG_FILTER_SMOOTH,1);
        # Output the CAPTCHA image into variable:

        ob_start();
        imagepng($image);
        $img = strval(ob_get_contents());
        ob_end_clean();
        imagedestroy($image);

        return $img;
    }
}

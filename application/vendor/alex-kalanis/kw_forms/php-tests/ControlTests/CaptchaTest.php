<?php

namespace ControlTests;


use ArrayAccess;
use CommonTestClass;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_rules\Interfaces\IRules;
use kalanis\kw_rules\Validate;


class CaptchaTest extends CommonTestClass
{
    /**
     * @throws RenderException
     */
    public function testCaptcha(): void
    {
        $captcha = new Captcha();
        $never = new Controls\Security\Timeout\NoTime();
        $always = new Controls\Security\Timeout\AnyTime();

        // obligatory call for usually unused methods
        $captcha->addRules();
        $captcha->removeRules();
        $this->assertEmpty($captcha->renderInput());
        $this->assertEmpty($captcha->renderErrors([]));

        // now real tests
        // render label - only when timeout says it
        $captcha->setLabel('uhbijnokm');
        $this->assertNotEmpty($captcha->renderLabel());
        $captcha->setTimeout($never);
        $this->assertNotEmpty($captcha->renderLabel());
        $captcha->setTimeout($always);
        $this->assertEmpty($captcha->renderInput());

        // rules - only when not need to pass
        $captcha->addRule(IRules::IS_FILLED, 'empty');
        $captcha->setTimeout($never);
        $this->assertNotEmpty($captcha->getRules());
        $captcha->setTimeout($always);
        $this->assertEmpty($captcha->getRules());
    }

    /**
     * @throws RenderException
     * @requires function imagettftext
     */
    public function testGraphical(): void
    {
        $session = new \MockArray();
        $captcha = new Graphical();
        $captcha->set('cpt', $session, 'die', $this->getFontPath());

        // obligatory call for usually unused methods
        $this->assertEmpty($captcha->renderErrors([]));
        $this->assertNotEmpty($captcha->renderInput());

        // now timeout render
        $captcha->setTimeout(new Controls\Security\Timeout\AnyTime());
        $this->assertEmpty($captcha->renderLabel());
        $captcha->setTimeout(new Controls\Security\Timeout\NoTime());
        $this->assertNotEmpty($captcha->renderLabel());
    }

    /**
     * @throws RenderException
     */
    public function testDisabled(): void
    {
        $captcha = new Controls\Security\Captcha\Disabled();

        // obligatory call for usually unused methods
        $captcha->addRule('none', 'none');
        $this->assertEmpty($captcha->getRules());
        $this->assertEmpty($captcha->renderInput());
        $this->assertEmpty($captcha->renderLabel());
        $this->assertEmpty($captcha->renderErrors([]));
    }

    public function testText(): void
    {
        $session = new \MockArray();
        $captcha = new Controls\Security\Captcha\Text();
        $captcha->set('cpt', $session, 'die', $this->getFontPath());

        // obligatory call for usually unused methods
        $captcha->addRule('none', 'none');

        $validate = new Validate();
        // correct one
        $session->offsetSet('cpt_last', $session->offsetGet('cpt_now')); // copy captcha data
        $captcha->setValue($session->offsetGet('cpt_last'));
        $this->assertTrue($validate->validate($captcha));
        $this->assertEmpty($validate->getErrors());
        // failed one
        $captcha->setValue('plkk');
        $this->assertFalse($validate->validate($captcha));
        $this->assertNotEmpty($validate->getErrors());
    }

    /**
     * @throws RenderException
     * @requires function imagettftext
     */
    public function testNumerical(): void
    {
        $session = new \MockArray();
        $captcha = new Controls\Security\Captcha\Numerical();
        $captcha->set('cpt', $session, 'die', $this->getFontPath());

        // obligatory call for usually unused methods
        $captcha->addRule('none', 'none');
        $this->assertEmpty($captcha->renderLabel());
        $this->assertNotEmpty($captcha->renderInput());

        $validate = new Validate();
        // correct one
        $session->offsetSet('cpt_last', $session->offsetGet('cpt_now')); // copy captcha data
        $captcha->setValue($session->offsetGet('cpt_last'));
        $this->assertTrue($validate->validate($captcha));
        $this->assertEmpty($validate->getErrors());
        // failed one
        $captcha->setValue('plkk');
        $this->assertFalse($validate->validate($captcha));
        $this->assertNotEmpty($validate->getErrors());
    }

    /**
     * @throws RenderException
     * @requires function imagettfbbox
     */
    public function testColourful(): void
    {
        $session = new \MockArray();
        $captcha = new Controls\Security\Captcha\ColourfulText();
        $captcha->set('cpt', $session, 'die', $this->getFontPath());

        // obligatory call for usually unused methods
        $captcha->addRule('none', 'none');
        $this->assertNotEmpty($captcha->renderLabel());

        $validate = new Validate();
        // correct one
        $session->offsetSet('cpt_last', $session->offsetGet('cpt_now')); // copy captcha data
        $captcha->setValue($session->offsetGet('cpt_last'));
        $this->assertTrue($validate->validate($captcha));
        $this->assertEmpty($validate->getErrors());
        // failed one
        $captcha->setValue('plkk');
        $this->assertFalse($validate->validate($captcha));
        $this->assertNotEmpty($validate->getErrors());
    }

    protected function getFontPath(): ?string
    {
        $path = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'data', 'freesans.ttf']));
        if (!$path) {
            $this->assertFalse(true, 'Need to find font for generating test images!');
        }
        return $path;
    }

    /**
     * @param int $id
     * @param string $instance
     * @dataProvider factoryProvider
     */
    public function testFactory(int $id, string $instance): void
    {
        $session = new \MockArray();
        $factory = new Controls\Security\Captcha\Factory();
        $this->assertInstanceOf($instance, $factory->getCaptcha($id, $session));
    }

    public function factoryProvider(): array
    {
        return [
            [Controls\Security\Captcha\Factory::TYPE_DISABLED,  '\kalanis\kw_forms\Controls\Security\Captcha\Disabled'],
            [Controls\Security\Captcha\Factory::TYPE_TEXT,      '\kalanis\kw_forms\Controls\Security\Captcha\Text'],
            [Controls\Security\Captcha\Factory::TYPE_MATH,      '\kalanis\kw_forms\Controls\Security\Captcha\Numerical'],
            [Controls\Security\Captcha\Factory::TYPE_COLOUR,    '\kalanis\kw_forms\Controls\Security\Captcha\ColourfulText'],
            [Controls\Security\Captcha\Factory::TYPE_NOCAPTCHA, '\kalanis\kw_forms\Controls\Security\Captcha\Nocaptcha'],
            [123,                                               '\kalanis\kw_forms\Controls\Security\Captcha\Text'],
        ];
    }
}


class Captcha extends Controls\Security\Captcha\ACaptcha
{
}


class Graphical extends Controls\Security\Captcha\AGraphical
{
    public function set(string $alias, ArrayAccess &$session, string $errorMessage, string $font = ''): self
    {
        $this->font = $font;
        $text = strtolower($this->generateRandomString(8));
        $this->setEntry($alias, null, $text);
        $this->fillSession($alias, $session, $text);
        return $this;
    }
}

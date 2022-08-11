<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Form\TControl;
use kalanis\kw_forms\Form\TMethod;
use kalanis\kw_input\Interfaces\IEntry;
use kalanis\kw_templates\HtmlElement\TAttributes;


class BasicTest extends CommonTestClass
{
    /**
     * @param string $type
     * @param array $params
     * @param string $instance
     * @dataProvider factoryProvider
     */
    public function testAddingTrait(string $type, array $params, string $instance): void
    {
        $factory = new Control();
        $control = call_user_func_array([$factory, $type], $params);
        $this->assertInstanceOf($instance, $control);
    }

    public function factoryProvider(): array
    {
        $outside = new \MockArray();
        return [
            ['addInput', ['any', 'simple'], '\kalanis\kw_forms\Controls\Input'],
            ['addInput', ['text', 'combine'], '\kalanis\kw_forms\Controls\Input'],
            ['addText', ['name', 'label', 'value'], '\kalanis\kw_forms\Controls\Text'],
            ['addEmail', ['from', 'sending'], '\kalanis\kw_forms\Controls\Email'],
            ['addPassword', ['pass', 'you know'], '\kalanis\kw_forms\Controls\Password'],
            ['addHidden', ['hide', 'me'], '\kalanis\kw_forms\Controls\Hidden'],
            ['addDatePicker', ['date', 'yesterday'], '\kalanis\kw_forms\Controls\DatePicker'],
            ['addDateTimePicker', ['meetup', 'tomorrow'], '\kalanis\kw_forms\Controls\DateTimePicker'],
            ['addDateRange', ['rage'], '\kalanis\kw_forms\Controls\DateRange'],
            ['addDescription', ['out', 'not hard'], '\kalanis\kw_forms\Controls\Description'],
            ['addHtml', ['in', 'burning'], '\kalanis\kw_forms\Controls\Html'],
            ['addTextarea', ['more', 'about other things'], '\kalanis\kw_forms\Controls\Textarea'],
            ['addSelect', ['name', 'label', 'value'], '\kalanis\kw_forms\Controls\Select'],
            ['addSelectList', ['name', 'label', ['check1' => 'foo', 'check2' => 'bar', 'check3' => 'baz', ], 3], '\kalanis\kw_forms\Controls\SelectList'],
            ['addRadios', ['name', 'label', 'value'], '\kalanis\kw_forms\Controls\RadioSet'],
            ['addCheckbox', ['name', 'label', 'value'], '\kalanis\kw_forms\Controls\Checkbox'],
            ['addCheckboxSwitch', ['name', 'label', 'value'], '\kalanis\kw_forms\Controls\CheckboxSwitch'],
            ['addCheckboxes', ['name', 'label', ['check1' => 'foo', 'check2' => 'bar', 'check3' => 'baz', ], ['check1', 'check3', 'check4']], '\kalanis\kw_forms\Controls\Checkboxes'],
            ['addFile', ['uploaded', 'file'], '\kalanis\kw_forms\Controls\File'],
            ['addFiles', ['passed', 'files'], '\kalanis\kw_forms\Controls\Files'],
            ['addButton', ['click', 'here'], '\kalanis\kw_forms\Controls\Button'],
            ['addReset', ['reload', 'reload'], '\kalanis\kw_forms\Controls\Reset'],
            ['addSubmit', ['submit', 'commit'], '\kalanis\kw_forms\Controls\Submit'],
            ['addMultiSend', ['outMulti', &$outside, 'our end'], '\kalanis\kw_forms\Controls\Security\MultiSend'],
            ['addCaptchaDisabled', ['captchaDis'], '\kalanis\kw_forms\Controls\Security\Captcha\Disabled'],
            ['addCaptchaText', ['captchaTxt', &$outside], '\kalanis\kw_forms\Controls\Security\Captcha\Text'],
            ['addCaptchaMath', ['captchaNum', &$outside], '\kalanis\kw_forms\Controls\Security\Captcha\Numerical'],
            ['addCaptchaColour', ['captchaCol', &$outside], '\kalanis\kw_forms\Controls\Security\Captcha\ColourfulText'],
            ['addNocaptcha', ['captcha'], '\kalanis\kw_forms\Controls\Security\Captcha\NoCaptcha'],
        ];
    }

    public function testMethod(): void
    {
        $method = new Method();
        $this->assertEmpty($method->getMethod());
        $method->setMethod(IEntry::SOURCE_ENV); // bad one
        $this->assertEmpty($method->getMethod());
        $method->setMethod(IEntry::SOURCE_GET); // good one
        $this->assertNotEmpty($method->getMethod());
        $this->assertEquals(IEntry::SOURCE_GET, $method->getMethod());
    }
}


class Method
{
    use TMethod;
    use TAttributes;
}


class Control
{
    use TControl;

    public function addControlDefaultKey(Controls\AControl $control): void
    {
        // nothing need to be implemented
    }

    public function setAttribute(string $name, string $value): void
    {
        // nothing need to be implemented
    }
}

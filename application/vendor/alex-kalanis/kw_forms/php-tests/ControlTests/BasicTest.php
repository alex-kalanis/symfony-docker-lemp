<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_forms\Interfaces;
use kalanis\kw_rules\Interfaces\IRules;
use kalanis\kw_rules\Validate;
use kalanis\kw_templates\Interfaces\IHtmlElement;
use kalanis\kw_templates\HtmlElement\TAttributes;
use kalanis\kw_templates\HtmlElement\THtmlElement;


class BasicTest extends CommonTestClass
{
    /**
     * @param string $type
     * @param string $instance
     * @throws FormsException
     * @dataProvider factoryProvider
     */
    public function testFactory(string $type, string $instance): void
    {
        $factory = new Controls\Factory();
        $control = $factory->getControl($type);
        $this->assertInstanceOf($instance, $control);
    }

    public function factoryProvider(): array
    {
        return [
            ['input', '\kalanis\kw_forms\Controls\Input'],
            ['text', '\kalanis\kw_forms\Controls\Text'],
            ['textarea', '\kalanis\kw_forms\Controls\Textarea'],
            ['email', '\kalanis\kw_forms\Controls\Email'],
            ['pass', '\kalanis\kw_forms\Controls\Password'],
            ['password', '\kalanis\kw_forms\Controls\Password'],
            ['phone', '\kalanis\kw_forms\Controls\Telephone'],
            ['telephone', '\kalanis\kw_forms\Controls\Telephone'],
            ['chk', '\kalanis\kw_forms\Controls\Checkbox'],
            ['check', '\kalanis\kw_forms\Controls\Checkbox'],
            ['checkbox', '\kalanis\kw_forms\Controls\Checkbox'],
            ['checkboxswitch', '\kalanis\kw_forms\Controls\CheckboxSwitch'],
            ['select', '\kalanis\kw_forms\Controls\Select'],
            ['selectbox', '\kalanis\kw_forms\Controls\Select'],
            ['radio', '\kalanis\kw_forms\Controls\Radio'],
            ['radioset', '\kalanis\kw_forms\Controls\RadioSet'],
            ['radiobutton', '\kalanis\kw_forms\Controls\Radio'],
            ['hidden', '\kalanis\kw_forms\Controls\Hidden'],
            ['date', '\kalanis\kw_forms\Controls\DatePicker'],
            ['datetime', '\kalanis\kw_forms\Controls\DateTimePicker'],
            ['daterange', '\kalanis\kw_forms\Controls\DateRange'],
            ['description', '\kalanis\kw_forms\Controls\Description'],
            ['desc', '\kalanis\kw_forms\Controls\Description'],
            ['html', '\kalanis\kw_forms\Controls\Html'],
            ['file', '\kalanis\kw_forms\Controls\File'],
            ['button', '\kalanis\kw_forms\Controls\Button'],
            ['accept', '\kalanis\kw_forms\Controls\Submit'],
            ['submit', '\kalanis\kw_forms\Controls\Submit'],
            ['cancel', '\kalanis\kw_forms\Controls\Reset'],
            ['reset', '\kalanis\kw_forms\Controls\Reset'],
            ['captchadis', '\kalanis\kw_forms\Controls\Security\Captcha\Disabled'],
            ['captchatext', '\kalanis\kw_forms\Controls\Security\Captcha\Text'],
            ['captchaplus', '\kalanis\kw_forms\Controls\Security\Captcha\Numerical'],
            ['nocaptcha', '\kalanis\kw_forms\Controls\Security\Captcha\NoCaptcha'],
            ['csrf', '\kalanis\kw_forms\Controls\Security\Csrf'],
            ['multisend', '\kalanis\kw_forms\Controls\Security\MultiSend'],
        ];
    }

    /**
     * @param mixed $type
     * @throws FormsException
     * @dataProvider factoryDieProvider
     */
    public function testFactoryDie($type): void
    {
        $factory = new Controls\Factory();
        $this->expectException(FormsException::class);
        $factory->getControl(strval($type));
    }

    public function factoryDieProvider(): array
    {
        return [
            ['\kalanis\kw_forms\Controls\Input'],
            ['something'],
            [123456],
        ];
    }

    public function testKey(): void
    {
        $key = new Key();
        $this->assertEmpty($key->getKey());
        $key->setKey('sdfghj');
        $this->assertNotEmpty($key->getKey());
        $this->assertEquals('sdfghj', $key->getKey());
    }

    public function testValue(): void
    {
        $value = new Value();
        $this->assertEmpty($value->getValue());
        $value->setValue('sdfghj');
        $this->assertNotEmpty($value->getValue());
        $this->assertEquals('sdfghj', $value->getValue());
    }

    public function testLabel(): void
    {
        $label = new Label();
        $this->assertEmpty($label->getLabel());
        $label->setLabel('yxcvbnm');
        $this->assertNotEmpty($label->getLabel());
        $this->assertEquals('yxcvbnm', $label->getLabel());
    }

    public function testTmplError(): void
    {
        $error = new TemplateError();
        $error->setTemplateError('');
        $this->assertEmpty($error->getTemplateError());
        $error->setTemplateError('lkjhgfdsa');
        $this->assertNotEmpty($error->getTemplateError());
        $this->assertEquals('lkjhgfdsa', $error->getTemplateError());
    }

    public function testChecked(): void
    {
        $checked = new Checked();
        $this->assertEmpty($checked->getValue());
        $checked->setValue('yxcvbnm');
        $this->assertEquals('rjgvnsg', $checked->getValue());
        $checked->setValue('none');
        $this->assertEmpty($checked->getValue());
    }

    public function testSelected(): void
    {
        $selected = new Selected();
        $this->assertEmpty($selected->getValue());
        $selected->setValue('rjgvnsg');
        $this->assertEquals('rjgvnsg', $selected->getValue());
        $selected->setValue('yxcvbnm');
        $this->assertEmpty($selected->getValue());
        $selected->setValue('none');
        $this->assertEmpty($selected->getValue());
    }

    public function testMultiple(): void
    {
        $multiple = new Multiple();
        $this->assertFalse($multiple->getMultiple());
        $multiple->setMultiple('yxcvbnm');
        $this->assertTrue($multiple->getMultiple());
        $multiple->setMultiple('none');
        $this->assertFalse($multiple->getMultiple());
    }

    public function testControl(): void
    {
        $validate = new Validate();

        $input = new Control();
        $input->addRule(IRules::IS_NOT_EMPTY, 'still empty!'); // factory, check for errors

        $this->assertEmpty($input->getLabel());
        $this->assertEmpty($input->renderLabel());
        $this->assertEquals(0, $input->count());

        $input->setLabel('not to look');
        $this->assertEquals('<label for="">not to look</label>', $input->renderLabel());
        $input->setAttribute('id', 'poiu');
        $this->assertEquals('<label for="poiu">not to look</label>', $input->renderLabel());

        $validate->validate($input); // check after init

        $this->assertEquals('still empty!', $input->renderErrors($validate->getErrors()[$input->getKey()])); // got errors

        $input->setValue('jhgfd');

        $validate->validate($input); // check after fill

        $this->assertEmpty($input->renderErrors($validate->getErrors())); // no errors
    }

    public function testWrapperInherit(): void
    {
        $wrappers = new Control();
        $wrappers->resetWrappers();
        $this->assertEmpty($wrappers->wrappers());
        $this->assertEmpty($wrappers->wrappersLabel());
        $this->assertEmpty($wrappers->wrappersInput());
        $this->assertEmpty($wrappers->wrappersChild());
        $this->assertEmpty($wrappers->wrappersChildren());
        $this->assertEmpty($wrappers->wrappersError());
        $this->assertEmpty($wrappers->wrappersErrors());

        $wrappers->addWrapper('span', ['style' => 'width:100em']);
        $wrappers->addWrapperLabel('div');
        $wrappers->addWrapperInput('div');
        $wrappers->addWrapperChild('span');
        $wrappers->addWrapperChildren(new Html(), ['class' => 'wat']);
        $wrappers->addWrapperError(['span', 'span']);
        $wrappers->addWrapperErrors('div');

        $sub = new Wrappers();
        $wrappers->inherit($sub);

        $sub->wrapping('div', $sub->wrappersInput());
    }

    public function testWrapperObject(): void
    {
        $wrappers = new Wrappers();
        $wrappers->resetWrappers();
        $this->assertEmpty($wrappers->wrappersLabel());
        $wrappers->addWrapperLabel('div');
        $wrappers->wrapping('div', new Html());
    }

    public function testWrapperDie(): void
    {
        $wrappers = new Wrappers();
        $wrappers->resetWrappers();
        $this->assertEmpty($wrappers->wrappersLabel());
        $wrappers->addWrapperLabel('div');
        $this->expectException(RenderException::class);
        $wrappers->wrapping('div', 123456);
    }
}


class Key
{
    use Controls\TKey;
}


class Value
{
    use Controls\TValue;
}


class Label
{
    use Controls\TLabel;
}


class TemplateError
{
    use Controls\TTemplateError;
}


class Checked
{
    use Controls\TChecked;
    use TAttributes;

    protected $originalValue = 'rjgvnsg';
}


class Selected
{
    use Controls\TSelected;
    use TAttributes;

    protected $originalValue = 'rjgvnsg';
}


class Multiple
{
    use Controls\TMultiple;
    use TAttributes;

    protected $originalValue = 'rjgvnsg';
    protected $children = [];
}


class Wrappers implements Interfaces\IWrapper, IHtmlElement
{
    use THtmlElement;
    use Controls\TWrappers;

    public function wrapping(string $string, $wrappers): string
    {
        return $this->wrapIt($string, $wrappers);
    }

    public function count(): int
    {
        return 0;
    }
}


class Html implements IHtmlElement
{
    use THtmlElement;

    public function count(): int
    {
        return 0;
    }
}


class Control extends Controls\AControl
{
}

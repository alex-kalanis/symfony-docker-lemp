<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;


class BoxTest extends CommonTestClass
{
    public function testBox(): void
    {
        $input = new Controls\Checkbox();
        $input->set('myown', 'original', 'check me');
        $id = $input->getAttribute('id');
        $this->assertEquals('<label for="' . $id . '">check me</label>', $input->renderLabel());
        $this->assertEquals('<input type="checkbox" value="original" id="' . $id . '" name="myown" />', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('original', $input->getOriginalValue());
        $this->assertEquals('<input type="checkbox" value="original" id="' . $id . '" name="myown" checked="checked" />', $input->renderInput());
    }

    public function testBoxes(): void
    {
        $extra = new Controls\Checkbox();
        $extra->set('edd', '1', 'fourth');

        $input = new Controls\Checkboxes();
        $input->set('myown', ['bar' => 'yep'], 'choose me', ['foo' => 'first', 'bar' => 'second', 'baz' => 'third', 'edd' => $extra]);

        $this->assertEquals(
  '<input type="checkbox" value="first" id="myown_foo" name="foo" /> <label for="myown_foo">first</label>' . PHP_EOL
. '<input type="checkbox" value="second" id="myown_bar" checked="checked" name="bar" /> <label for="myown_bar">second</label>' . PHP_EOL
. '<input type="checkbox" value="third" id="myown_baz" name="baz" /> <label for="myown_baz">third</label>' . PHP_EOL
. '<input type="checkbox" value="1" id="myown_edd" name="edd" /> <label for="myown_edd">fourth</label>' . PHP_EOL, $input->renderInput());
        $input->setValues(['baz' => 'yep']);
        $values = $input->getValues();
        $this->assertEmpty($values['bar']);
        $this->assertEquals('third', $values['baz']);
        $this->assertEquals(
  '<input type="checkbox" value="first" id="myown_foo" name="foo" /> <label for="myown_foo">first</label>' . PHP_EOL
. '<input type="checkbox" value="second" id="myown_bar" name="bar" /> <label for="myown_bar">second</label>' . PHP_EOL
. '<input type="checkbox" value="third" id="myown_baz" name="baz" checked="checked" /> <label for="myown_baz">third</label>' . PHP_EOL
. '<input type="checkbox" value="1" id="myown_edd" name="edd" /> <label for="myown_edd">fourth</label>' . PHP_EOL, $input->renderInput());
    }

    public function testRadio(): void
    {
        $input = new Controls\Radio();
        $input->set('myown', 'original', 'choose me');
        $this->assertEquals('<label for="myown">choose me</label>', $input->renderLabel());
        $this->assertEquals('<input type="radio" value="original" id="myown" name="myown" />', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('<input type="radio" value="original" id="myown" name="myown" checked="checked" />', $input->renderInput());

        $this->assertNotEmpty($input->render());
    }

    public function testRadioSet(): void
    {
        $extra = new Controls\Radio();
        $extra->set('edd', '1', 'fourth');

        $input = new Controls\RadioSet();
        $input->set('myown', 'bar', 'choose me', ['foo' => 'first', 'bar' => 'second', 'baz' => 'third', 'edd' => $extra]);

        $this->assertEquals(
  '<input type="radio" value="foo" id="myown_foo" name="myown" /> <label for="myown_foo">first</label>' . PHP_EOL
. '<input type="radio" value="bar" checked="checked" id="myown_bar" name="myown" /> <label for="myown_bar">second</label>' . PHP_EOL
. '<input type="radio" value="baz" id="myown_baz" name="myown" /> <label for="myown_baz">third</label>' . PHP_EOL
. '<input type="radio" value="1" id="myown_1" name="myown" /> <label for="myown_1">fourth</label>', $input->renderInput());
        $input->setValue('baz');
        $this->assertEquals('baz', $input->getValue());
        $this->assertEquals(
  '<input type="radio" value="foo" id="myown_foo" name="myown" /> <label for="myown_foo">first</label>' . PHP_EOL
. '<input type="radio" value="bar" id="myown_bar" name="myown" /> <label for="myown_bar">second</label>' . PHP_EOL
. '<input type="radio" value="baz" id="myown_baz" name="myown" checked="checked" /> <label for="myown_baz">third</label>' . PHP_EOL
. '<input type="radio" value="1" id="myown_1" name="myown" /> <label for="myown_1">fourth</label>', $input->renderInput());
        $input->setValue('eff'); // unknown
        $this->assertEmpty($input->getValue());
    }
}

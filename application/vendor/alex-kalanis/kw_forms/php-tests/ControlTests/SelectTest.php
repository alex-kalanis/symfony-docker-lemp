<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;


class SelectTest extends CommonTestClass
{
    public function testOption(): void
    {
        $input = new Controls\SelectOption();
        $input->setEntry('unused', 'original', 'check me');
        $this->assertEmpty($input->renderLabel());
        $this->assertEmpty($input->renderErrors([]));
        $this->assertEquals('original', $input->getOriginalValue());
        $this->assertEquals('<option value="original">check me</option>', $input->renderInput());
        $input->setValue('original');
        $this->assertEquals('<option value="original" selected="selected">check me</option>', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('<option value="original">check me</option>', $input->renderInput());
    }

    public function testGrouping(): void
    {
        $extra = new Controls\SelectOption();
        $extra->setEntry('edd', '1', 'fourth');

        $input = new Controls\SelectOptgroup();
        $input->set('myown', 'choose me', ['foo' => 'first', 'bar' => 'second', 'baz' => 'third', 'edd' => $extra]);

        $this->assertEmpty($input->renderErrors([]));
        $this->assertEquals(
  '<optgroup label="choose me"> <option value="foo">first</option> ' . PHP_EOL
. ' <option value="bar">second</option> ' . PHP_EOL
. ' <option value="baz">third</option> ' . PHP_EOL
. ' <option value="1">fourth</option> </optgroup>', $input->renderInput());
        $input->setValue('baz');
        $this->assertEquals('baz', $input->getValue());
        $this->assertEquals(
  '<optgroup label="choose me"> <option value="foo">first</option> ' . PHP_EOL
. ' <option value="bar">second</option> ' . PHP_EOL
. ' <option value="baz" selected="selected">third</option> ' . PHP_EOL
. ' <option value="1">fourth</option> </optgroup>', $input->renderInput());
        $input->setValue('out');
        $this->assertEmpty($input->getValue());
    }

    public function testSimpleSelect(): void
    {
        $extra = new Controls\SelectOption();
        $extra->setEntry('edd', '1', 'fourth');

        $group = new Controls\SelectOptgroup();
        $group->set('myown', 'choose me', ['foo' => 'first', 'bar' => 'second', 'baz' => 'third', ]);

        $childs = [
            'choose this' => $group,
            'choose another' => [
                'fss' => 'fifth',
                'dfg' => 'sixth',
            ],
            'edd' => $extra,
            'srr' => 'last',
        ];

        $input = new Controls\Select();
        $input->set('myown', 'original', 'choose some', $childs);

        $this->assertEquals('', $input->getValue());
        $this->assertEquals(
  '<select  id="myown" name="myown"> <optgroup label="choose me"> <option value="foo">first</option> ' . PHP_EOL
. ' <option value="bar">second</option> ' . PHP_EOL
. ' <option value="baz">third</option> </optgroup> ' . PHP_EOL
. ' <optgroup label="choose another"> <option value="fss">fifth</option> ' . PHP_EOL
. ' <option value="dfg">sixth</option> </optgroup> ' . PHP_EOL
. ' <option value="1">fourth</option> ' . PHP_EOL
. ' <option value="srr">last</option> </select>', $input->renderInput());
        $input->setValue('dfg');
        $this->assertEquals('dfg', $input->getValue());
        $this->assertEquals(
  '<select  id="myown" name="myown"> <optgroup label="choose me"> <option value="foo">first</option> ' . PHP_EOL
. ' <option value="bar">second</option> ' . PHP_EOL
. ' <option value="baz">third</option> </optgroup> ' . PHP_EOL
. ' <optgroup label="choose another"> <option value="fss">fifth</option> ' . PHP_EOL
. ' <option value="dfg" selected="selected">sixth</option> </optgroup> ' . PHP_EOL
. ' <option value="1">fourth</option> ' . PHP_EOL
. ' <option value="srr">last</option> </select>', $input->renderInput());
        $input->setValue('1');
        $this->assertEquals('1', $input->getValue());
        $this->assertEquals(
  '<select  id="myown" name="myown"> <optgroup label="choose me"> <option value="foo">first</option> ' . PHP_EOL
. ' <option value="bar">second</option> ' . PHP_EOL
. ' <option value="baz">third</option> </optgroup> ' . PHP_EOL
. ' <optgroup label="choose another"> <option value="fss">fifth</option> ' . PHP_EOL
. ' <option value="dfg">sixth</option> </optgroup> ' . PHP_EOL
. ' <option value="1" selected="selected">fourth</option> ' . PHP_EOL
. ' <option value="srr">last</option> </select>', $input->renderInput());
    }

    public function testListSelect(): void
    {
        $extra = new Controls\SelectOption();
        $extra->setEntry('edd', '1', 'fourth');

        $childs = [
            'foo' => 'first',
            'bar' => 'second',
            'baz' => 'third',
            'edd' => $extra,
            'srr' => 'last',
        ];

        $input = new Controls\SelectList();
        $input->set('myown', 'choose some', $childs, 4);

        $this->assertEquals('', $input->getValue());
        $this->assertEquals(
            '<select  size="4" id="myown" name="myown"> <option value="foo">first</option> ' . PHP_EOL
            . ' <option value="bar">second</option> ' . PHP_EOL
            . ' <option value="baz">third</option> ' . PHP_EOL
            . ' <option value="1">fourth</option> ' . PHP_EOL
            . ' <option value="srr">last</option> </select>', $input->renderInput());
        $input->setValue('baz');
        $this->assertEquals('baz', $input->getValue());
        $this->assertEquals(
            '<select  size="4" id="myown" name="myown"> <option value="foo">first</option> ' . PHP_EOL
            . ' <option value="bar">second</option> ' . PHP_EOL
            . ' <option value="baz" selected="selected">third</option> ' . PHP_EOL
            . ' <option value="1">fourth</option> ' . PHP_EOL
            . ' <option value="srr">last</option> </select>', $input->renderInput());
        $input->setValue('1');
        $this->assertEquals('1', $input->getValue());
        $this->assertEquals(
            '<select  size="4" id="myown" name="myown"> <option value="foo">first</option> ' . PHP_EOL
            . ' <option value="bar">second</option> ' . PHP_EOL
            . ' <option value="baz">third</option> ' . PHP_EOL
            . ' <option value="1" selected="selected">fourth</option> ' . PHP_EOL
            . ' <option value="srr">last</option> </select>', $input->renderInput());
        $input->setValues(['foo', 'srr']);
        $this->assertEquals('foo', $input->getValue());
        $this->assertEquals(
            '<select  size="4" id="myown" name="myown"> <option value="foo" selected="selected">first</option> ' . PHP_EOL
            . ' <option value="bar">second</option> ' . PHP_EOL
            . ' <option value="baz">third</option> ' . PHP_EOL
            . ' <option value="1">fourth</option> ' . PHP_EOL
            . ' <option value="srr" selected="selected">last</option> </select>', $input->renderInput());
        $this->assertNotEmpty($input->getValues());
    }
}

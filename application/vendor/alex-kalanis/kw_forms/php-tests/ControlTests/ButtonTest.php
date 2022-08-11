<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;


class ButtonTest extends CommonTestClass
{
    public function testButton(): void
    {
        $input = new Controls\Button();
        $input->set('commit', 'myown');
        $this->assertEquals('<input type="button" value="myown" id="commit" name="commit" />', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('<input type="button" value="jhgfd" id="commit" name="commit" />', $input->renderInput());
    }

    public function testButton2(): void
    {
        $input = new Controls\Button();
        $input->set('myown');
        $this->assertEquals('<input type="button" value="myown" id="myown" name="myown" />', $input->renderInput());
        $input->set('', 'myown');
        $this->assertEquals('<input type="button" value="myown" id="myown" name="myown" />', $input->renderInput());
    }

    public function testSubmit(): void
    {
        $input = new Controls\Submit();
        $input->set('myown', 'not to look');
        $this->assertEquals('<input type="submit" value="not to look" id="myown" name="myown" />', $input->renderInput());
        $this->assertEmpty($input->getValue());
        $input->setValue('jhgfd');
        $this->assertEquals('<input type="submit" value="not to look" id="myown" name="myown" />', $input->renderInput());
        $this->assertNotEmpty($input->getValue());
        $input->setValue(null);
        $this->assertEquals('<input type="submit" value="not to look" id="myown" name="myown" />', $input->renderInput());
        $this->assertEmpty($input->getValue());
        $input->setTitle('jhgfd');
        $this->assertEquals('<input type="submit" value="jhgfd" id="myown" name="myown" />', $input->renderInput());
    }

    public function testReset(): void
    {
        $input = new Controls\Reset();
        $input->set('myown', 'not to look');
        $this->assertEquals('<input type="reset" value="not to look" id="myown" name="myown" />', $input->renderInput());
        $input->set('', 'myown');
        $this->assertEquals('<input type="reset" value="myown" id="myown" name="myown" />', $input->renderInput());
    }
}

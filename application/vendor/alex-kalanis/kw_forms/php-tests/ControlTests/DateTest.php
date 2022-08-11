<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;


class DateTest extends CommonTestClass
{
    public function testDate(): void
    {
        $input = new Controls\DatePicker();
        $input->set('commit', 'original', 'not to look');
        $this->assertEquals('<input type="text" value="" class="datepicker" id="commit" name="commit" />', $input->renderInput());
        $input->setValue(1333571265);
        $input->setDateFormat('Y-m-d H:i');
        $this->assertEquals('<input type="text" value="2012-04-04 20:27" class="datepicker" id="commit" name="commit" />', $input->renderInput());
        $input->setValue('2010-08-18 22:33');
        $this->assertEquals('<input type="text" value="2010-08-18 22:33" class="datepicker" id="commit" name="commit" />', $input->renderInput());
    }

    public function testRange(): void
    {
        $input = new Range();
        $input->resetUniq();
        $input->set('myown', 'original', 'not to look');
        $this->assertEquals(
  ' <input type="text" value="" class="datepicker" id="myown_0" name="myown[]" /> '. PHP_EOL
. ' <input type="text" value="" class="datepicker" id="myown_1" name="myown[]" /> ', $input->renderInput());
    }
}


class Range extends Controls\DateRange
{
    /**
     * Just for discarding problems with catching ids
     */
    public function resetUniq(): void
    {
        self::$uniqid = 0;
    }
}

<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;


class SpecialTest extends CommonTestClass
{
    public function testControlEscape(): void
    {
        Controls\Hidden::escapeOutput(false); // it affects both outputs

        $input1 = new Controls\Hidden();
        $input1->set('myown', '__$°#&@{}^<>*~đĐ[]`\'łŁ$|€¶ŧ←↓→øþ[]\\``!@#$%^&*{}\\');

        $input2 = new Controls\Text();
        $input2->set('myown', '<?php =eval("echo evil code")');

        $this->assertEquals(' <input type="hidden" value="__$°#&@{}^<>*~đĐ[]`\'łŁ$|€¶ŧ←↓→øþ[]\``!@#$%^&*{}\" name="myown" /> ', $input1->render());
        $this->assertEquals(' <input type="text" value="<?php =eval("echo evil code")" id="myown" name="myown" /> ', $input2->render());

        Controls\Text::escapeOutput(true); // it affects both outputs

        $this->assertEquals(' <input type="hidden" value="__$°#&amp;@{}^&lt;&gt;*~đĐ[]`&apos;łŁ$|€¶ŧ←↓→øþ[]\``!@#$%^&amp;*{}\" name="myown" /> ', $input1->render());
        $this->assertEquals(' <input type="text" value="&lt;?php =eval(&quot;echo evil code&quot;)" id="myown" name="myown" /> ', $input2->render());
    }

    public function testHidden(): void
    {
        $input = new Controls\Hidden();
        $input->set('myown', 'original');
        $this->assertEquals('<input type="hidden" value="original" name="myown" />', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('<input type="hidden" value="jhgfd" name="myown" />', $input->renderInput());
    }

    public function testDescription(): void
    {
        $input = new Controls\Description();
        $input->setEntry('myown', 'original', 'not to look');
        $this->assertEquals('original ', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('jhgfd ', $input->renderInput());
    }

    public function testHtml(): void
    {
        $input = new Controls\Html();
        $input->setEntry('myown', 'original', 'not to look');
        $this->assertEquals('<span  name="myown">original</span>', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('<span  name="myown">jhgfd</span>', $input->renderInput());
    }
}

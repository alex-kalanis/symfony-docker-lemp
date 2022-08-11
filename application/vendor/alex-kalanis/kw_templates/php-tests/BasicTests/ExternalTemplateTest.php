<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\ExternalTemplate;
use kalanis\kw_templates\Template;


class ExternalTemplateTest extends CommonTestClass
{
    public function testSimple()
    {
        $template = new MockExternalTemplate1();
        $this->assertEmpty($template->render());
        $template->setTemplate('Testing content for your play - it needs more than simple check');
        $this->assertEquals('Testing content for your play - it needs more than simple check', $template->render());
    }
}


class MockExternalTemplate1 extends ExternalTemplate
{
    use Template\TInputs;
}

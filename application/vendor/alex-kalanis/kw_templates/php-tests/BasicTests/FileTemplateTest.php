<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template;
use kalanis\kw_templates\TemplateException;


class FileTemplateTest extends CommonTestClass
{
    public function testSimple()
    {
        $template = new MockFileTemplate1();
        $this->assertEquals('Something to test', $template->render());
    }

    public function testUnknown()
    {
        $this->expectException(TemplateException::class);
        new MockFileTemplate2();
    }
}


class MockFileTemplate1 extends ATemplate
{
    use Template\TFile;
    use Template\TInputs;

    protected function templatePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'dummy_content.txt';
    }
}


class MockFileTemplate2 extends ATemplate
{
    use Template\TFile;
    use Template\TInputs;

    protected function templatePath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'failed_content.txt';
    }
}

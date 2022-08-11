<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\GroupedTemplate;
use kalanis\kw_templates\Template;
use kalanis\kw_templates\TemplateException;


class GroupTemplateTest extends CommonTestClass
{
    public function testSimple()
    {
        $template = new MockGroupedTemplate1();
        $this->assertEmpty($template->render());
        $template->useHead();
        $this->assertEquals('available from every part', $template->render());
        $template->useUl();
        $this->assertNotEquals('available from every part', $template->render());
        $this->assertEquals('unordered list: found', $template->render());
    }

    public function testUnknown()
    {
        $template = new MockGroupedTemplate1();
        $this->expectException(TemplateException::class);
        $template->useUnknown(); // crash - nothing found
    }
}


class MockGroupedTemplate1 extends GroupedTemplate
{
    use Template\TInputs;

    protected function defineAvailableTemplates(): array
    {
        return [
            'head' => 'available from *what*',
            'ul' => 'unordered list: *content*',
        ];
    }

    public function useHead(): void
    {
        $this->resetItems();
        $this->selectTemplate('head');
        $this->addInput('*what*', 'nowhere', 'every part');
    }

    public function useUl(): void
    {
        $this->resetItems();
        $this->selectTemplate('ul');
        $this->addInput('*content*', 'not found', 'found');
    }

    public function useUnknown(): void
    {
        $this->resetItems();
        $this->selectTemplate('fake');
    }
}

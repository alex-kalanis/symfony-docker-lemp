<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template;
use kalanis\kw_templates\TemplateException;


class TemplateTest extends CommonTestClass
{
    public function testSimple()
    {
        $template = new MockTemplate1();
        $this->assertEquals('Testing content for your play - it needs more than simple check', $template->render());
        $template->change('e', 'x');
        $this->assertEquals('Txsting contxnt for your play - it nxxds morx than simplx chxck', $template->render());
        $template->reset();
        $this->assertEquals(' more than s', $template->getSubstring(40, 12));

        $template->paste('no less', 32, 13);
        $this->assertEquals('Testing content for your play - no less than simple check', $template->render());
    }

    /**
     * @throws TemplateException
     */
    public function testNothingFound()
    {
        $template = new MockTemplate1();
        $this->assertEquals(35, $template->position('needs'));
        $this->expectException(TemplateException::class);
        $template->position('needs', 45); // crash - nothing found
    }

    public function testInputs()
    {
        $template = new MockTemplate2();
        $this->assertEquals('Another template for fun with known issues', $template->render());
        $template->reset();
        $template->updateFill();
        $this->assertEquals('Another template for fun with lost ideas', $template->render());
        $item = $template->getExisting();
        $this->assertEquals('/fill/', $item->getKey());
        $this->assertEquals('lost ideas', $item->getValue());
        $this->assertEmpty($template->getProblematic());
    }
}


class MockTemplate1 extends ATemplate
{
    use Template\TInputs;

    protected function loadTemplate(): string
    {
        return 'Testing content for your play - it needs more than simple check';
    }
}


class MockTemplate2 extends ATemplate
{
    protected function fillInputs(): void
    {
        $this->addInput('/fill/', 'known issues');
    }

    protected function loadTemplate(): string
    {
        return 'Another template for fun with /fill/';
    }

    public function updateFill(): void
    {
        $this->updateItem('/fill/', 'lost ideas');
    }

    public function getExisting(): ?Template\Item
    {
        return $this->getItem('/fill/');
    }

    public function getProblematic(): ?Template\Item
    {
        return $this->getItem('/none/');
    }
}

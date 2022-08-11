<?php

namespace kalanis\kw_paging\Render\SimplifiedPager;


use kalanis\kw_paging\Interfaces\IPositions;
use kalanis\kw_paging\Render\THelpingText;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class Pager extends ATemplate
{
    use TFile;
    use THelpingText;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/Pager.phtml';
    }

    protected function fillInputs(): void
    {
        $this->addInput('{PAGES}');
        $this->addInput('{HELPING_TEXT}');
    }

    public function setData(string $pages, ?IPositions $positions): self
    {
        $this->updateItem('{PAGES}', $pages);
        $this->updateItem('{HELPING_TEXT}', $this->getFilledText($positions));
        return $this;
    }
}

<?php

namespace kalanis\kw_paging\Render\DefaultPager;


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
        $this->addInput('{PREV_PAGES}');
        $this->addInput('{PAGES}');
        $this->addInput('{NEXT_PAGES}');
        $this->addInput('{HELPING_TEXT}');
    }

    public function setData(string $prevPages, string $nextPages, string $pages, ?IPositions $positions): self
    {
        $this->updateItem('{PREV_PAGES}', $prevPages);
        $this->updateItem('{PAGES}', $pages);
        $this->updateItem('{NEXT_PAGES}', $nextPages);
        $this->updateItem('{HELPING_TEXT}', $this->getFilledText($positions));
        return $this;
    }
}

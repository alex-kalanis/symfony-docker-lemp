<?php

namespace kalanis\kw_paging\Render\DefaultPager;


use kalanis\kw_paging\Interfaces\ILink;
use kalanis\kw_paging\Interfaces\IPositions;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class PrevPage extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/PrevPage.phtml';
    }

    protected function fillInputs(): void
    {
        $this->addInput('{FIRST_PAGE_URL}');
        $this->addInput('{PREV_PAGE_URL}');
    }

    public function setData(ILink $link, IPositions $positions): self
    {
        $link->setPageNumber($positions->getFirstPage());
        $this->updateItem('{FIRST_PAGE_URL}', $link->getPageLink());
        $link->setPageNumber($positions->getPrevPage());
        $this->updateItem('{PREV_PAGE_URL}', $link->getPageLink());
        return $this;
    }
}

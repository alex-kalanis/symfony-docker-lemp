<?php

namespace kalanis\kw_paging\Render\DefaultPager;


use kalanis\kw_paging\Interfaces\ILink;
use kalanis\kw_paging\Interfaces\IPositions;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class NextPage extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/NextPage.phtml';
    }

    protected function fillInputs(): void
    {
        $this->addInput('{NEXT_PAGE_URL}');
        $this->addInput('{LAST_PAGE_URL}');
    }

    public function setData(ILink $link, IPositions $positions): self
    {
        $link->setPageNumber($positions->getNextPage());
        $this->updateItem('{NEXT_PAGE_URL}', $link->getPageLink());
        $link->setPageNumber($positions->getLastPage());
        $this->updateItem('{LAST_PAGE_URL}', $link->getPageLink());
        return $this;
    }
}

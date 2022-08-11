<?php

namespace kalanis\kw_paging\Render\SimplifiedPager;


use kalanis\kw_paging\Interfaces\ILink;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class CurrentPage extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/CurrentPage.phtml';
    }

    protected function fillInputs(): void
    {
        $this->addInput('{PAGE_URL}');
        $this->addInput('{PAGE_NUMBER}');
    }

    public function setData(ILink $link, string $pageNumber): self
    {
        $this->updateItem('{PAGE_URL}', $link->getPageLink());
        $this->updateItem('{PAGE_NUMBER}', $pageNumber);
        return $this;
    }
}
<?php

namespace kalanis\kw_paging\Render\DefaultPager;


use kalanis\kw_paging\Interfaces\ILink;
use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class AnotherPage extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/AnotherPage.phtml';
    }

    protected function fillInputs(): void
    {
        $this->addInput('{PAGE_URL}');
        $this->addInput('{PAGE_NUMBER}');
    }

    public function setData(ILink $link, int $pageNumber): self
    {
        $link->setPageNumber($pageNumber);
        $this->updateItem('{PAGE_URL}', $link->getPageLink());
        $this->updateItem('{PAGE_NUMBER}', strval($pageNumber));
        return $this;
    }
}

<?php

namespace kalanis\kw_paging\Render\DefaultPager;


use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class NextPageDisabled extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/NextPageDisabled.phtml';
    }

    protected function fillInputs(): void
    {
    }
}

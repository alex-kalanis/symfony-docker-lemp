<?php

namespace kalanis\kw_paging\Render\DefaultPager;


use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class PrevPageDisabled extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        return __DIR__ . '/Templates/PrevPageDisabled.phtml';
    }

    protected function fillInputs(): void
    {
    }
}

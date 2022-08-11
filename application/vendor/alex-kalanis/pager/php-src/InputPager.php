<?php

namespace kalanis\kw_pager;


class InputPager extends BasicPager
{
    public function __construct(Interfaces\ISettings $setting, Interfaces\IActualInput $page)
    {
        $this->setMaxResults($setting->getMaxResults());
        $this->setActualPage($page->getActualPage());
        $this->setLimit($setting->getLimit());
    }
}

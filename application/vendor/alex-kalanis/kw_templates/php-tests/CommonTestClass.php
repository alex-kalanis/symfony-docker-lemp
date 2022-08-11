<?php

use kalanis\kw_templates\Template;
use PHPUnit\Framework\TestCase;


class CommonTestClass extends TestCase
{
//    public function providerBasic()
//    {
//    }

    protected function mockItem(): Template\Item
    {
        return (new Template\Item())->setData(
            'testing content',
            'default content %s'
        );
    }
}

<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\HtmlElement;


/**
 * Class HtmlTest
 * @package BasicTests
 * How to check traits? Extend them.
 */
class HtmlTest extends CommonTestClass
{
    public function testSimple1()
    {
        $data = HtmlElement::init('<hr align="left">', ['width' => '80',]);
        $this->assertNotEmpty($data->getAttributes());
        $this->assertEquals('left', $data->getAttribute('align'));
        $this->assertEquals('80', $data->getAttribute('width'));
    }

    public function testSimple2()
    {
        $data = HtmlElement::init('span', ['height' => '80',]);
        $this->assertNotEmpty($data->getAttributes());
        $this->assertEmpty($data->getAttribute('width'));
        $this->assertEquals('80', $data->getAttribute('height'));
    }
}

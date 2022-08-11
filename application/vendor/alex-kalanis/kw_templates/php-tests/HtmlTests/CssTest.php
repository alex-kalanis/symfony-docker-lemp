<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\HtmlElement\TAttributes;
use kalanis\kw_templates\HtmlElement\TCss;


/**
 * Class CssTest
 * @package BasicTests
 * How to check traits? Extend them.
 */
class CssTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = new Css();
        $this->assertEmpty($data->getAttributes());
        $this->assertEmpty($data->getAttribute('class'));
        $data->addClass('foo');
        $data->addClass('bar');
        $data->addClass('baz');
        $this->assertEquals('foo bar baz', $data->getAttribute('class'));
        $data->removeClass('bar');
        $this->assertEquals('foo baz', $data->getAttribute('class'));
    }
}


class Css
{
    use TAttributes, TCss;
}

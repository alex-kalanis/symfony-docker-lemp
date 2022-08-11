<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\HtmlElement\TAttributes;
use kalanis\kw_templates\HtmlElement\TStyles;


/**
 * Class StylesTest
 * @package BasicTests
 * How to check traits? Extend them.
 */
class StylesTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = new Styles();
        $this->assertEmpty($data->getAttributes());
        $this->assertEmpty($data->getAttribute('style'));
        $data->addCss('foo', 'snt');
        $data->addCss('bar', 'fgs');
        $data->addCss('baz', 'sdf');
        $this->assertEquals('sdf', $data->getCss('baz'));
        $this->assertEquals('foo:snt;bar:fgs;baz:sdf;', $data->getAttribute('style'));
        $data->removeCss('bar');
        $this->assertEquals('foo:snt;baz:sdf;', $data->getAttribute('style'));
    }
}


class Styles
{
    use TAttributes, TStyles;
}

<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\HtmlElement\TAttributes;


/**
 * Class AttributeTest
 * @package BasicTests
 * How to check traits? Extend them.
 */
class AttributeTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = new Attributes();
        $this->assertEmpty($data->getAttributes());
        $this->assertEmpty($data->getAttribute('foo'));
        $data->setAttribute('foo', 'bar');
        $this->assertEquals('bar', $data->getAttribute('foo'));
        $data->setAttribute('foo', 'baz');
        $this->assertEquals('baz', $data->getAttribute('foo'));
        $data->removeAttribute('foo');
        $this->assertEmpty($data->getAttribute('foo'));
        $this->assertEmpty($data->getAttributes());
    }

    public function testExtend()
    {
        $data = new Attributes();
        $this->assertEmpty($data->getAttributes());
        $data->setAttribute('foo', 'bar');
        $data->setAttribute('ijn', 'ujm');
        $data->addAttributes([
            'ijn' => 'zgv',
            'edc' => 'rdx',
        ]);
        $this->assertEquals('zgv', $data->getAttribute('ijn'));
        $data->addAttributes([
            'ojv' => [
                'lkj',
                'nbv',
                'gfd',
            ],
        ]);
        $this->assertEquals('lkj;nbv;gfd', $data->getAttribute('ojv'));

        $data->setAttributes([]);
        $this->assertEmpty($data->getAttributes());
    }

    public function testStringInput()
    {
        $data = new Attributes();
        $this->assertEmpty($data->getAttributes());
        $data->addAttributes('avail="from:left;insecure:15em;"');
        $this->assertEquals('from:left;insecure:15em;', $data->getAttribute('avail'));
        $data->setAttribute('avail', 'xrb');
        $this->assertEquals('xrb', $data->getAttribute('avail'));
    }

    public function testRender()
    {
        $data = new Attributes();
        $this->assertEmpty($data->getAttributes());
        $data->addAttributes('avail="from:left;insecure:15em;"');
        $data->setAttribute('foo', 'bar');
        $data->setAttribute('ijn', 'ujm');
        $this->assertEquals(' avail="from:left;insecure:15em;" foo="bar" ijn="ujm"', $data->render());
    }
}


class Attributes
{
    use TAttributes;

    public function render(): string
    {
        return $this->renderAttributes();
    }
}

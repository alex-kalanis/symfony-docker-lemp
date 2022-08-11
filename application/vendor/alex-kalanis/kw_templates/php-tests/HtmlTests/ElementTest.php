<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\AHtmlElement;


/**
 * Class ElementTest
 * @package BasicTests
 * How to check abstracts? Extend them.
 */
class ElementTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = new Element('exe');
        $this->assertEquals('exe', $data->getAlias());
    }

    public function testAttributes()
    {
        $data = new Element('exe');
        $this->assertEmpty($data->dummy());
        $data->dummy('resggs');
        $this->assertEquals('resggs', $data->dummy());
        $data->removeAttribute('dummy');
        $this->assertEmpty($data->dummy());
        $data->foo('fkhlg', 'fpklasg');
        $this->assertEmpty($data->foo());
    }

    public function testChildren()
    {
        $data = new Element('exe');
        $this->assertEmpty(iterator_to_array($data->getChildren()));
        $data->setChildren([
            0 => new SomeChild(),
            'dome' => new ElseChild(),
            'anno' => 'whyy',
        ]);
        $this->assertEmpty($data->dummy);
        $data->dummy = 'resggs';
        $this->assertInstanceOf('\kalanis\kw_templates\AHtmlElement', $data->dummy);
        $this->assertInstanceOf('\kalanis\kw_templates\AHtmlElement', $data->dome);
        $this->assertInstanceOf('\kalanis\kw_templates\AHtmlElement', $data->__get(0));
        $data->__set('or', new NextChild());
        $data->removeChild('dome');
        $this->assertTrue($data->__empty('dome'));
        $this->assertEmpty($data->dome);

        $this->assertFalse($data->offsetExists('fahd'));
        $data->offsetSet('fahd', new ElseChild());
        $this->assertTrue($data->offsetExists('fahd'));
        $this->assertInstanceOf('\kalanis\kw_templates\AHtmlElement', $data->offsetGet('fahd'));
        $data->offsetUnset('fahd');
        $this->assertFalse($data->offsetExists('fahd'));

        $this->assertNotEmpty(iterator_to_array($data->getIterator()));
    }

    public function testInheritance()
    {
        $original = new Element('exe');
        $original->setAttributes([
            'cde' => 'zfx',
            'vfr' => 'ohv',
        ]);
        $sender = new SomeChild();
        $result = $original->inherit($sender);

        $this->assertEquals('ohv', $result->getAttribute('vfr'));
        $this->assertEquals('zfx', $result->getAttribute('cde'));
        $this->assertNotEquals($result, $original);
    }

    public function testMerge()
    {
        $data = new Element('exe');
        $data->setAttributes([
            'cde' => 'zfx',
            'vfr' => 'ohv',
        ]);
        $result = new SomeChild();
        $result->merge($data);

        $this->assertEquals('ohv', $result->getAttribute('vfr'));
        $this->assertEquals('zfx', $result->getAttribute('cde'));
    }

    public function testRender()
    {
        $data = new Element('exe');
        $data->setAttributes([
            'cde' => 'zfx',
            'vfr' => 'ohv',
        ]);
        $data1 = new SomeChild();
        $data1->setAttributes([
            'vfr' => 'ohv',
        ]);
        $data2 = new ElseChild();
        $data2->setAttributes([
            'cde' => 'zfx',
        ]);

        $data3 = new ElseChild();
        $data3->setAttributes([
            'fht' => 'kgs',
        ]);

        $data->addChild($data1);
        $data->addChild($data2, 'doo');

        $this->assertEquals('-- cde="zfx" vfr="ohv"-- ::poiuztrewq  vfr="ohv" ' . "\n" . '::lkjhgfdsa  cde="zfx" ', $data->render());
        $data->addChild($data3, 'doo', true);

        $this->assertEquals('-- cde="zfx" vfr="ohv"-- ::poiuztrewq  vfr="ohv" ' . "\n" . '::lkjhgfdsa  fht="kgs" ', $data->render());
    }
}


class Element extends AHtmlElement
{
    protected $template = '--%s-- %s';

    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }
}


class SomeChild extends AHtmlElement
{
    protected $template = '::poiuztrewq %s %s';
}


class ElseChild extends AHtmlElement
{
    protected $template = '::lkjhgfdsa %s %s';
}


class NextChild extends AHtmlElement
{
    protected $template = 'mnbvcxy %s %s';
}

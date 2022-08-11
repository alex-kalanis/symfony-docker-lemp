<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\AHtmlElement;


/**
 * Class ParentTest
 * @package BasicTests
 * How to check traits? Extend them.
 */
class ParentTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = new CurrentChild();
        $this->assertEmpty($data->getParent());
        $this->assertEmpty($data->count());
        $data->setParent(new ParentElement());
        $this->assertEquals(0, $data->getParent()->count());
        $this->assertInstanceOf('\kalanis\kw_templates\AHtmlElement', $data);
        $data->append(new AnotherChild());
        $this->assertEmpty($data->count());
        $this->assertNotEquals(0, $data->getParent()->count());
        $this->assertInstanceOf('\BasicTests\AnotherChild', $data->getParent()->lastChild());
        $data->setParent(null);
        $this->assertEmpty($data->getParent());
    }
}


class CurrentChild extends AHtmlElement
{
}


class AnotherChild extends AHtmlElement
{
}


class ParentElement extends AHtmlElement
{
}

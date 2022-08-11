<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_templates\HtmlElement\Text;


/**
 * Class TextTest
 * @package BasicTests
 */
class TextTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = new Text('foo <bar> baz', 'bdr');
        $this->assertEquals('bdr', $data->getAlias());
        $this->assertEquals('foo <bar> baz', strval($data));
    }
}

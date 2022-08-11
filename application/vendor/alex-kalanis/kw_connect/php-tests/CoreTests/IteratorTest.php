<?php

namespace CoreTests;


use CommonTestClass;
use kalanis\kw_connect\core\AIterator;


class IteratorTest extends CommonTestClass
{
    public function testIterator()
    {
        $data = new Iter();
        $this->assertInstanceOf('\ArrayAccess', $data);
        $this->assertInstanceOf('\IteratorAggregate', $data);
        $this->assertInstanceOf('\Countable', $data);

        $this->assertEmpty($data->count());

        $data->offsetSet('different', 'another');
        $data->offsetSet('wub', 'wuz');

        $this->assertEquals(2, $data->count());

        $this->assertEquals('another', $data->offsetGet('different'));
        $this->assertEquals('wuz', $data->offsetGet('wub'));
        $this->assertNull($data->offsetGet('unknown'));

        $data->offsetUnset('different');
        $this->assertEquals(1, $data->count());

        $data->offsetUnset('unknown');
        $this->assertEquals(1, $data->count());

        $data->getIterator();
    }
}


class Iter extends AIterator
{
    protected $testing = [];

    protected function getIterableName(): string
    {
        return 'testing';
    }
}

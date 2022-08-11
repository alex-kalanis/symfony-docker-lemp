<?php

namespace BasicTests;


use CommonTestClass;


class ItemTest extends CommonTestClass
{
    public function testSimple()
    {
        $data = $this->mockItem();
        $this->assertInstanceOf('\kalanis\kw_templates\Template\Item', $data);
        $this->assertEquals('testing content', $data->getKey());
        $this->assertEquals('default content %s', $data->getDefault());
        $this->assertEquals('default content %s', $data->getValue());

        $data->setValue('different %s %s');
        $this->assertNotEquals('default content %s', $data->getValue());
        $this->assertEquals('different %s %s', $data->getValue());

        $data->updateValue('conv', 'val');
        $this->assertEquals('different conv val', $data->getValue());

        $data->setValue(null);
        $data->updateValue('conv', 'val');
        $this->assertEquals('default content conv', $data->getValue());

        $data2 = clone $data;
        $data2->setData('new test', 'another content %f');
        $this->assertEquals('new test', $data2->getKey());
        $this->assertNotEquals('new test', $data->getKey());
    }
}

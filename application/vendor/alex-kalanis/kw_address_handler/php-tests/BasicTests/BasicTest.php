<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_address_handler\Handler;
use kalanis\kw_address_handler\SingleVariable;
use kalanis\kw_address_handler\Sources;


class BasicTest extends CommonTestClass
{
    public function testEmptySources(): void
    {
        $handler = new Handler();
        $this->assertNull($handler->getSource());
        $this->assertNull($handler->getAddress());
        $this->assertNotNull($handler->getParams());

        $handler = new Handler(new Sources\Sources());
        $this->assertNotEmpty($handler->getSource());
        $this->assertEquals('?', $handler->getAddress());
        $this->assertNotEmpty($handler->getParams());
        $this->assertEquals([], $handler->getParams()->getParamsData());
    }

    public function testBasic(): void
    {
        $handler = new Handler(new Sources\Address('//abc/def//?ghi=jkl&mno=pqr&stu=vwx'));
        $this->assertNotEmpty($handler->getSource());
        $this->assertNotEmpty($handler->getParams());
        $this->assertNotEmpty($handler->getParams()->getParamsData());
        $handler->getParams()->offsetUnset('mno');
        $vars = new SingleVariable($handler->getParams());
        $vars->setVariableName('poiu')->setVariableValue('ztrewq');
        $this->assertEquals('/abc/def//?ghi=jkl&stu=vwx&poiu=ztrewq', $handler->getAddress());
    }
}

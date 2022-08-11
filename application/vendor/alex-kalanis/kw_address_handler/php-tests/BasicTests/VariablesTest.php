<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_address_handler\SingleVariable;
use kalanis\kw_address_handler\Params;


class VariablesTest extends CommonTestClass
{
    public function testParams(): void
    {
        $params = new Params();
        $params->setParamsData([
            'abc' => 'def',
            'ghi' => 'jkl',
            'mno' => 'pqr',
            'stu' => 'vwx',
        ]);
        $this->assertNotEmpty($params->getParamsData());
        $this->assertNotEquals(null, $params->offsetGet('ghi'));
        $this->assertEquals(null, $params->offsetGet('jkl'));

        $params->offsetSet('poi', 'okm');
        $this->assertTrue($params->offsetExists('poi'));
        $params->offsetUnset('poi');
        $this->assertFalse($params->offsetExists('poi'));
    }

    public function testSingleVariables(): void
    {
        $params = new Params();
        $params->setParamsData([
            'abc' => 'def',
            'ghi' => 'jkl',
            'mno' => 'pqr',
            'stu' => 'vwx',
        ]);
        $vars = new SingleVariable($params);
        $this->assertEquals('variable', $vars->getVariableName());
        $this->assertEmpty($vars->getVariableValue());
        $this->assertEquals('', $vars->getVariableValue());
        $vars->setVariableValue('zgvuhb');
        $this->assertNotEmpty($vars->getVariableValue());
        $vars->setVariableName('mno');
        $this->assertEquals('mno', $vars->getVariableName());
        $this->assertEquals('pqr', $vars->getVariableValue());
    }
}

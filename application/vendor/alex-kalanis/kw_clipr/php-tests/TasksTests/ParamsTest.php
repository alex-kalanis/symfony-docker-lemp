<?php

namespace TasksTests;


use CommonTestClass;
use kalanis\kw_clipr\Tasks\Params;


class ParamsTest extends CommonTestClass
{
    public function testOption(): void
    {
        $instance = new Params\Option();
        $instance->setData('mnb', 'vcx', 'pewrit','tdtr', null, 'rsef');
        $instance->setValue('zrsg');
        $this->assertEquals('zrsg', $instance->getValue());
        $this->assertEquals('mnb', $instance->getVariable());
        $this->assertEquals('vcx', $instance->getCliKey());
        $this->assertEquals('pewrit', $instance->getMatch());
        $this->assertEquals('tdtr', $instance->getDefaultValue());
        $this->assertEquals(null, $instance->getShort());
        $this->assertEquals('rsef', $instance->getDescription());

        $instance2 = new Params\Option();
        $instance2->setData('fdh', 'gjx', 'wvgsdh',false, 'm', 'vsdfvd');
        $this->assertEquals('fdh', $instance2->getVariable());
        $this->assertEquals('gjx', $instance2->getCliKey());
        $this->assertEquals('wvgsdh', $instance2->getMatch());
        $this->assertEquals(false, $instance2->getDefaultValue());
        $this->assertEquals('m', $instance2->getShort());
        $this->assertEquals('vsdfvd', $instance2->getDescription());
    }

    public function testParam(): void
    {
        $inputs = $this->getParams();
        $instance = new Params($inputs);
        $instance->addParam('abc', 'abc', '#iuz(.*)$#i', 'nope');
        $instance->addParam('def', 'abc', '#jhg(.*)$#i', 'nope');
        $instance->addParam('ghi', 'abc', '#^po(.*)t(.*)$#i', 'nope');
        $instance->addParam('jkl', 'gaad', null, 'nope');
        $instance->addParam('mno', 'gaad', null, true);
        $instance->addParam('pqr', 'giid', null, false, 'g');
        $instance->addParam('stu', 'giid', null, 'defa');
        $instance->addParam('yz', 'abc', '#ztr#i', 'nope');

        iterator_to_array($instance->getAvailableOptions());

        $this->assertTrue(isset($instance->abc));
        $this->assertEquals('trewq', $instance->abc);
        $this->assertTrue(isset($instance->def));
        $this->assertEquals('nope', $instance->def);
        $this->assertTrue(isset($instance->ghi));
        $this->assertEquals('iuz', $instance->ghi[1]);
        $this->assertEquals('rewq', $instance->ghi[2]);
        $this->assertTrue(isset($instance->jkl));
        $this->assertEquals(true, $instance->jkl); // from input
        $this->assertTrue(isset($instance->mno));
        $this->assertEquals(false, $instance->mno); // bool rotation - set true, found -> rotate to false
        $this->assertTrue(isset($instance->pqr));
        $this->assertEquals(true, $instance->pqr); // found short key
        $this->assertTrue(isset($instance->stu));
        $this->assertEquals('defa', $instance->stu);
        $this->assertFalse(isset($instance->vwx));
        $this->assertEquals(null, $instance->vwx);
    }

    protected function getParams(): array
    {
        return [
            'abc' => $this->initEntry('abc', 'abc', 'poiuztrewq'),
            'g' => $this->initEntry('g', 'g', true),
            'gaad' => $this->initEntry('aggd', 'gaad', true),
//            '' => $this->initEntry('', '', ''),
        ];
    }

}

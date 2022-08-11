<?php

use kalanis\kw_input\Simplified;


class SimplifiedTest extends CommonTestClass
{
    public function testCookie()
    {
        Simplified\CookieAdapter::init('', '', null, false, false, false);
        $data = new Simplified\CookieAdapter();
        $this->assertInstanceOf('\ArrayAccess', $data);

        $data->foz = 'wuz';
        $this->assertTrue(isset($data->foz));
        $this->assertEquals('wuz', $data->foz);
        unset($data->foz);

        $data['ugg'] = 'huu';
        $this->assertTrue(isset($data['ugg']));
        $this->assertEquals('huu', $data['ugg']);
        unset($data['ugg']);

        $nullKey = 'bnm' . chr(0) . 'lkj';
        $data[$nullKey] = 'thd';
        $this->assertTrue(isset($data[$nullKey]));
        $this->assertTrue(isset($data['bnmlkj']));
        $this->assertEquals('thd', $data[$nullKey]);
        $this->assertEquals('thd', $data['bnmlkj']);
        unset($data[$nullKey]);
    }

    public function testCookieDie1()
    {
        Simplified\CookieAdapter::init('', '', null, false, false, false, true);
        $data = new Simplified\CookieAdapter();
        $this->expectException(\kalanis\kw_input\InputException::class);
        $data->foz = 'wuz';
    }

    public function testCookieDie2()
    {
        Simplified\CookieAdapter::init('', '', null, false, false, false, true);
        $data = new Simplified\CookieAdapter();
        $this->expectException(\kalanis\kw_input\InputException::class);
        unset($data->foz);
    }

    public function testSession()
    {
        $data = new Simplified\SessionAdapter();
        $this->assertInstanceOf('\ArrayAccess', $data);

        $data->foz = 'wuz';
        $this->assertTrue(isset($data->foz));
        $this->assertEquals('wuz', $data->foz);
        unset($data->foz);

        $data['ugg'] = 'huu';
        $this->assertTrue(isset($data['ugg']));
        $this->assertEquals('huu', $data['ugg']);
        unset($data['ugg']);

        $nullKey = 'bnm' . chr(0) . 'lkj';
        $data[$nullKey] = 'thd';
        $this->assertTrue(isset($data[$nullKey]));
        $this->assertTrue(isset($data['bnmlkj']));
        $this->assertEquals('thd', $data[$nullKey]);
        $this->assertEquals('thd', $data['bnmlkj']);
        unset($data[$nullKey]);
    }

    public function testServer()
    {
        $data = new Simplified\ServerAdapter();
        $this->assertInstanceOf('\ArrayAccess', $data);
        $this->assertTrue(isset($data->PHP_SELF));
        $this->assertTrue(isset($data['PHP_SELF']));
        $data->PHP_SELF;
        $data['PHP_SELF'];
    }

    public function testServerDie1()
    {
        $data = new Simplified\ServerAdapter();
        $this->expectException(\kalanis\kw_input\InputException::class);
        $data->foz = 'wuz';
    }

    public function testServerDie2()
    {
        $data = new Simplified\ServerAdapter();
        $this->expectException(\kalanis\kw_input\InputException::class);
        unset($data->foz);
    }
}

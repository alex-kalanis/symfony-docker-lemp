<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Interfaces\ICsrf;
use kalanis\kw_rules\Validate;


class SecurityTest extends CommonTestClass
{
    public function testMultiSend(): void
    {
        $cookie = new \MockArray();
        $send = new Controls\Security\MultiSend();
        $send->setHidden('sender', $cookie, 'died');

        // obligatory call for usually unused methods
        $send->addRule('', '');
        $send->addRules();
        $send->removeRules();
        $this->assertEmpty($send->renderErrors([]));

        $valid = new Validate();
        // check - first round
        $this->assertTrue($valid->validate($send));
        $this->assertEmpty($valid->getErrors());
        // second round - must fail there
        $this->assertFalse($valid->validate($send));
        $this->assertNotEmpty($valid->getErrors());
    }

    public function testCsrf(): void
    {
        $session = new \MockArray();
        $csrf = new Csrf();
        $csrf->setHidden('sender', $session, 'died');

        // obligatory call for usually unused methods
        $csrf->addRule('', '');
        $csrf->addRules();
        $csrf->removeRules();
        $this->assertEmpty($csrf->renderErrors([]));
        $this->assertNotEmpty($csrf->getLib()->getExpire());

        $valid = new Validate();
        // check - first round
        $this->assertTrue($valid->validate($csrf));
        $this->assertEmpty($valid->getErrors());
        // second round - did not fail there - set new values
        $this->assertTrue($valid->validate($csrf));
        $this->assertEmpty($valid->getErrors());
        // third round - set bad value, this fails
        $csrf->setValue('kljhgfdsa');
        $this->assertFalse($valid->validate($csrf));
        $this->assertNotEmpty($valid->getErrors());
    }

    public function testTimeoutNever(): void
    {
        $time = new Controls\Security\Timeout\NoTime();
        $time->updateExpire();
        $this->assertFalse($time->isRunning());
    }

    public function testTimeoutEver(): void
    {
        $time = new Controls\Security\Timeout\AnyTime();
        $time->updateExpire();
        $this->assertTrue($time->isRunning());
    }

    public function testTimeout(): void
    {
        $session = new \MockArray();
        $time = new Controls\Security\Timeout\Timeout($session, 10);
        $this->assertFalse($time->isRunning());
        $time->updateExpire();
        $this->assertTrue($time->isRunning());

        $another = new Controls\Security\Timeout\Timeout($session, 10);
        $this->assertTrue($another->isRunning());
    }
}


class Csrf extends Controls\Security\Csrf
{
    protected function getCsrfLib(): ICsrf
    {
        return new Controls\Security\Csrf\Simple();
    }

    public function getLib(): ICsrf
    {
        return $this->csrf;
    }
}

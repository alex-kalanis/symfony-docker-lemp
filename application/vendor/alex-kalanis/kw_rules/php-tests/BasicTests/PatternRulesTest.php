<?php

use kalanis\kw_rules\Rules;
use kalanis\kw_rules\Exceptions\RuleException;


class PatternRulesTest extends CommonTestClass
{
    /**
     * @param string $checkValue
     * @param bool $isEmail
     * @param bool $isDomain
     * @throws RuleException
     * @dataProvider stringsProvider
     */
    public function testEmail(string $checkValue, bool $isEmail, bool $isDomain)
    {
        $data = new Rules\IsEmail();
        $data->setAgainstValue('');
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);

        $mock = MockEntry::init('foo', $checkValue);
        if (!$isEmail) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    /**
     * @param string $checkValue
     * @param bool $isEmail
     * @param bool $isDomain
     * @throws RuleException
     * @dataProvider stringsProvider
     */
    public function testDomain(string $checkValue, bool $isEmail, bool $isDomain)
    {
        $data = new Rules\IsDomain();
        $data->setAgainstValue('');
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);

        $mock = MockEntry::init('foo', $checkValue);
        if (!$isDomain) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    public function stringsProvider()
    {
        return [
            ['foo@bar.example',     true,  false],
            ['foo@bar.baz.example', true,  false],
            ['foo@bar@baz.example', false, false],
            ['6',                   false, false],
            ['bar.example',         false, true ],
            ['foo.bar.baz.example', false, false],
        ];
    }
}

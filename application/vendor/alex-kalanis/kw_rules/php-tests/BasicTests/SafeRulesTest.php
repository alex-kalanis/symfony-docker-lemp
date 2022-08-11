<?php

use kalanis\kw_rules\Rules;
use kalanis\kw_rules\Exceptions\RuleException;


class SafeRulesTest extends CommonTestClass
{
    /**
     * @param string $key
     * @param string $expectedValue
     * @param string $checkValue
     * @param bool $gotResult
     * @throws RuleException
     * @dataProvider equalsProvider
     */
    public function testEqualsSafeBasic(string $key, string $expectedValue, string $checkValue, bool $gotResult)
    {
        $data = new Rules\Safe\HashedBasicEquals();
        $data->setAgainstValue($expectedValue);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $mock = MockEntry::init($key, $checkValue);
        if (!$gotResult) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    /**
     * @param string $key
     * @param string $expectedValue
     * @param string $checkValue
     * @param bool $gotResult
     * @throws RuleException
     * @dataProvider equalsProvider
     */
    public function testEqualsSafeFunc(string $key, string $expectedValue, string $checkValue, bool $gotResult)
    {
        $data = new Rules\Safe\HashedFuncEquals();
        $data->setAgainstValue($expectedValue);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $mock = MockEntry::init($key, $checkValue);
        if (!$gotResult) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

}

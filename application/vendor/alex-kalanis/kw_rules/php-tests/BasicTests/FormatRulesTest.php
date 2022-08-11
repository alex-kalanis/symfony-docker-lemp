<?php

use kalanis\kw_rules\Rules;
use kalanis\kw_rules\Exceptions\RuleException;


class FormatRulesTest extends CommonTestClass
{
    /**
     * @param string $value
     * @param bool $resultBool
     * @param bool $resultNum
     * @param bool $resultStr
     * @throws RuleException
     * @dataProvider compareFormatProvider
     */
    public function testFormatBool($value, bool $resultBool, bool $resultNum, bool $resultStr)
    {
        $data = new Rules\IsBool();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        if (!$resultBool) $this->expectException(RuleException::class);
        $data->validate(MockEntry::init('foo', $value));
    }

    /**
     * @param string $value
     * @param bool $resultBool
     * @param bool $resultNum
     * @param bool $resultStr
     * @throws RuleException
     * @dataProvider compareFormatProvider
     */
    public function testFormatNumeric($value, bool $resultBool, bool $resultNum, bool $resultStr)
    {
        $data = new Rules\IsNumeric();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        if (!$resultNum) $this->expectException(RuleException::class);
        $data->validate(MockEntry::init('foo', $value));
    }

    /**
     * @param string $value
     * @param bool $resultBool
     * @param bool $resultNum
     * @param bool $resultStr
     * @throws RuleException
     * @dataProvider compareFormatProvider
     */
    public function testFormatString($value, bool $resultBool, bool $resultNum, bool $resultStr)
    {
        $data = new Rules\IsString();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        if (!$resultStr) $this->expectException(RuleException::class);
        $data->validate(MockEntry::init('foo', $value));
    }

    public function compareFormatProvider()
    {
        return [
            [false,           true,  false, false],
            [123,             false, true,  false],
            ['abc',           false, false, true],
            [new \stdClass(), false, false, false],
        ];
    }
}

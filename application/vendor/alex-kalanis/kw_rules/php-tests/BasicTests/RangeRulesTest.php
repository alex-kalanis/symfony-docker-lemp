<?php

use kalanis\kw_rules\Rules;
use kalanis\kw_rules\Exceptions\RuleException;


class RangeRulesTest extends CommonTestClass
{
    /**
     * @param mixed $expectedValue
     * @param bool $gotException
     * @throws RuleException
     * @dataProvider inputRangeProvider
     */
    public function testRangeSet($expectedValue, bool $gotException)
    {
        $data = new Rules\InRange();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        if ($gotException) $this->expectException(RuleException::class);
        $data->setAgainstValue($expectedValue);
    }

    public function inputRangeProvider()
    {
        return [
            [['8', '4'], false],
            ['8', true], // no array
            [new \stdClass(), true], // class
            [['abc', ['8', '4']], true], // sub-array
            [[new \stdClass(), new \stdClass()], true], // classes
            [['8', 22, 2, 13, '4'], false], // choose your fun
        ];
    }

    /**
     * @param string|int $checkValue
     * @param string|int $lowerLimit
     * @param string|int $upperLimit
     * @param bool $range
     * @param bool $rangeEq
     * @throws RuleException
     * @dataProvider compareRangesProvider
     */
    public function testRangeIn($checkValue, $lowerLimit, $upperLimit, bool $range, bool $rangeEq)
    {
        $data = new Rules\InRange();
        $data->setAgainstValue([$lowerLimit, $upperLimit]);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $mock = MockEntry::init('foo', $checkValue);
        if (!$range) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    /**
     * @param string|int $checkValue
     * @param string|int $lowerLimit
     * @param string|int $upperLimit
     * @param bool $range
     * @param bool $rangeEq
     * @throws RuleException
     * @dataProvider compareRangesProvider
     */
    public function testRangeInEquals($checkValue, $lowerLimit, $upperLimit, bool $range, bool $rangeEq)
    {
        $data = new Rules\InRangeEquals();
        $data->setAgainstValue([$lowerLimit, $upperLimit]);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $mock = MockEntry::init('foo', $checkValue);
        if (!$rangeEq) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    /**
     * @param string|int $checkValue
     * @param string|int $lowerLimit
     * @param string|int $upperLimit
     * @param bool $range
     * @param bool $rangeEq
     * @throws RuleException
     * @dataProvider compareRangesProvider
     */
    public function testRangeOut($checkValue, $lowerLimit, $upperLimit, bool $range, bool $rangeEq)
    {
        $data = new Rules\OutRange();
        $data->setAgainstValue([$lowerLimit, $upperLimit]);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $mock = MockEntry::init('foo', $checkValue);
        if ($range) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    /**
     * @param string|int $checkValue
     * @param string|int $lowerLimit
     * @param string|int $upperLimit
     * @param bool $range
     * @param bool $rangeEq
     * @throws RuleException
     * @dataProvider compareRangesProvider
     */
    public function testRangeOutEquals($checkValue, $lowerLimit, $upperLimit, bool $range, bool $rangeEq)
    {
        $data = new Rules\OutRangeEquals();
        $data->setAgainstValue([$lowerLimit, $upperLimit]);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $mock = MockEntry::init('foo', $checkValue);
        if ($rangeEq) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    public function compareRangesProvider()
    {
        return [
            [2,  '8', '4',  false, false, ],
            [2,  '8', '2',  false, true,  ],
            [6,  '4', '8',  true,  true,  ],
            [10, '2', '10', false, true,  ],
            [10, '2', '6',  false, false, ],
        ];
    }
}

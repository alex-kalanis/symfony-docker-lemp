<?php

use kalanis\kw_rules\Rules;
use kalanis\kw_rules\Exceptions\RuleException;


class LengthRulesTest extends CommonTestClass
{
    /**
     * @param string $value
     * @param int $length
     * @param bool $passMin
     * @param bool $passEq
     * @param bool $passMax
     * @throws RuleException
     * @dataProvider compareLenProvider
     */
    public function testLengthMin(string $value, int $length, bool $passMin, bool $passEq, bool $passMax)
    {
        $data = new Rules\LengthMin();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $data->setAgainstValue($length);
        if (!$passMin) $this->expectException(RuleException::class);
        $data->validate(MockEntry::init('foo', $value));
    }

    /**
     * @param string $value
     * @param int $length
     * @param bool $passMin
     * @param bool $passEq
     * @param bool $passMax
     * @throws RuleException
     * @dataProvider compareLenProvider
     */
    public function testLengthEquals(string $value, int $length, bool $passMin, bool $passEq, bool $passMax)
    {
        $data = new Rules\LengthEquals();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $data->setAgainstValue($length);
        if (!$passEq) $this->expectException(RuleException::class);
        $data->validate(MockEntry::init('foo', $value));
    }

    /**
     * @param string $value
     * @param int $length
     * @param bool $passMin
     * @param bool $passEq
     * @param bool $passMax
     * @throws RuleException
     * @dataProvider compareLenProvider
     */
    public function testLengthMax(string $value, int $length, bool $passMin, bool $passEq, bool $passMax)
    {
        $data = new Rules\LengthMax();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\ARule', $data);
        $data->setAgainstValue($length);
        if (!$passMax) $this->expectException(RuleException::class);
        $data->validate(MockEntry::init('foo', $value));
    }

    public function compareLenProvider()
    {
        return [
            ['yxcvbnm',   8, false, false, true ],
            ['asdfghjk',  8, true,  true,  true ],
            ['qwertutop', 8, true,  false, false],
        ];
    }
}

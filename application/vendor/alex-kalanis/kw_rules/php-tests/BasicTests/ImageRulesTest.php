<?php

use kalanis\kw_rules\Rules\File;
use kalanis\kw_rules\Exceptions\RuleException;


class ImageRulesTest extends CommonTestClass
{
    /**
     * @throws RuleException
     */
    public function testImageExists()
    {
        $data = new File\ImageIs();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->validate($this->getMockImage());
    }

    /**
     * @throws RuleException
     */
    public function testImageNotExists()
    {
        $data = new File\ImageIs();
        $this->expectException(RuleException::class);
        $data->validate($this->getMockFile());
    }

    /**
     * @param string $maxSizeX
     * @param string $maxSizeY
     * @param bool $matchEquals
     * @throws RuleException
     * @dataProvider sizeMatchProvider
     */
    public function testImageMatchSize(string $maxSizeX, string $maxSizeY, bool $matchEquals)
    {
        $data = new File\ImageSizeEquals();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->setAgainstValue([$maxSizeX, $maxSizeY]);
        if (!$matchEquals) $this->expectException(RuleException::class);
        $data->validate($this->getMockImage());
    }

    public function testImageMatchSizeFail()
    {
        $data = new File\ImageSizeEquals();
        $this->expectException(RuleException::class);
        $data->setAgainstValue('not array');
    }

    /**
     * @param string $maxSizeX
     * @param string $maxSizeY
     * @param bool $matchEquals
     * @param bool $matchMin
     * @param bool $matchMax
     * @throws RuleException
     * @dataProvider sizeMatchProvider
     */
    public function testImageMatchListSize(string $maxSizeX, string $maxSizeY, bool $matchEquals, bool $matchMin, bool $matchMax)
    {
        $data = new File\ImageSizeList();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->setAgainstValue([[$maxSizeX, $maxSizeY]]);
        if (!$matchEquals) $this->expectException(RuleException::class);
        $data->validate($this->getMockImage());
    }

    public function testImageMatchListSizeFailString()
    {
        $data = new File\ImageSizeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue('abcdef');
    }

    public function testImageMatchListSizeFailSimpleArray()
    {
        $data = new File\ImageSizeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue(['12', '34']);
    }

    /**
     * @param string $maxSizeX
     * @param string $maxSizeY
     * @param bool $matchEquals
     * @param bool $matchMin
     * @param bool $matchMax
     * @throws RuleException
     * @dataProvider sizeMatchProvider
     */
    public function testImageMatchMinSize(string $maxSizeX, string $maxSizeY, bool $matchEquals, bool $matchMin, bool $matchMax)
    {
        $data = new File\ImageSizeMin();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->setAgainstValue([$maxSizeX, $maxSizeY]);
        if (!$matchMin) $this->expectException(RuleException::class);
        $data->validate($this->getMockImage());
    }

    public function testImageMatchMinSizeFail()
    {
        $data = new File\ImageSizeMin();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $this->expectException(RuleException::class);
        $data->setAgainstValue('123456');
    }

    /**
     * @param string $maxSizeX
     * @param string $maxSizeY
     * @param bool $matchEquals
     * @param bool $matchMin
     * @param bool $matchMax
     * @throws RuleException
     * @dataProvider sizeMatchProvider
     */
    public function testImageMatchMaxSize(string $maxSizeX, string $maxSizeY, bool $matchEquals, bool $matchMin, bool $matchMax)
    {
        $data = new File\ImageSizeMax();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->setAgainstValue([$maxSizeX, $maxSizeY]);
        if (!$matchMax) $this->expectException(RuleException::class);
        $data->validate($this->getMockImage());
    }

    public function testImageMatchMaxSizeFail()
    {
        $data = new File\ImageSizeMax();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $this->expectException(RuleException::class);
        $data->setAgainstValue('123456');
    }

    public function sizeMatchProvider()
    {
        return [
            ['6', '5', true,  true,  true ],
            ['5', '6', false, false, false],
            ['5', '5', false, true,  false],
            ['6', '6', false, false, true ],
            ['4', '0', false, true,  false],
            ['0', '7', false, false, true ],
        ];
    }
}

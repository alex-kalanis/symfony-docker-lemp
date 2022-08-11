<?php

use kalanis\kw_rules\Rules\File;
use kalanis\kw_rules\Exceptions\RuleException;


class FileRulesTest extends CommonTestClass
{
    /**
     * @throws RuleException
     */
    public function testFileExists()
    {
        $data = new File\FileExists();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->validate($this->getMockFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileNotExists()
    {
        $data = new File\FileExists();
        $this->expectException(RuleException::class);
        $data->validate($this->getMockNoFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileSent()
    {
        $data = new File\FileSent();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->validate($this->getMockFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileNotSent()
    {
        $data = new File\FileSent();
        $this->expectException(RuleException::class);
        $data->validate($this->getMockNoFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileReceived()
    {
        $data = new File\FileReceived();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->validate($this->getMockFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileNotReceived()
    {
        $data = new File\FileReceived();
        $this->expectException(RuleException::class);
        $data->validate($this->getMockNoFile());
    }

    /**
     * @param string $maxSize
     * @param int $fileSize
     * @param bool $match
     * @throws RuleException
     * @dataProvider sizeMatchProvider
     */
    public function testFileMaxSize(string $maxSize, int $fileSize, bool $match)
    {
        $data = new File\FileMaxSize();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->setAgainstValue($maxSize);
        $mock = MockFile::init('foo', 'text0.txt', 'text/plain',
            '', $fileSize, UPLOAD_ERR_OK );
        if (!$match) $this->expectException(RuleException::class);
        $data->validate($mock);
    }

    public function sizeMatchProvider()
    {
        return [
            ['32',  128,   false],
            ['10g', 46843, true],
            ['15m', 84641, true],
            ['30k', 3534,  true],
            ['30k', 35534, false],
        ];
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeEquals()
    {
        $data = new File\FileMimeEquals();
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->setAgainstValue('text/plain');
        $data->validate($this->getMockFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeNotEquals()
    {
        $data = new File\FileMimeEquals();
        $data->setAgainstValue('octet/stream');
        $this->expectException(RuleException::class);
        $data->validate($this->getMockFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeListFailString()
    {
        $data = new File\FileMimeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue('text/plain');
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeListFailNumber()
    {
        $data = new File\FileMimeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue(123456);
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeListFailClass()
    {
        $data = new File\FileMimeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue(new \stdClass());
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeListFailArrayNumber()
    {
        $data = new File\FileMimeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue([123456]);
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeListFailArrayClass()
    {
        $data = new File\FileMimeList();
        $this->expectException(RuleException::class);
        $data->setAgainstValue([new \stdClass()]);
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeList()
    {
        $data = new File\FileMimeList();
        $data->setAgainstValue(['text/plain']);
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $data->validate($this->getMockFile());
    }

    /**
     * @throws RuleException
     */
    public function testFileMimeNotList()
    {
        $data = new File\FileMimeList();
        $data->setAgainstValue(['octet/stream']);
        $this->expectException(RuleException::class);
        $data->validate($this->getMockFile());
    }
}

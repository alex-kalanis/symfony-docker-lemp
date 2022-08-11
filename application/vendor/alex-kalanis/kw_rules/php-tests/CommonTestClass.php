<?php

use kalanis\kw_rules\Rules;
use kalanis\kw_rules\TRules;
use kalanis\kw_rules\Interfaces;
use PHPUnit\Framework\TestCase;


class CommonTestClass extends TestCase
{
    public function equalsProvider()
    {
        return [
            ['abc', 'def', 'def', true],
            ['foo', 'bar', 'baz', false],
        ];
    }

    protected function getMockImage()
    {
        return MockFile::init('foo', 'test1.gif', 'text/plain',
            realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, 'data', 'tester.gif'])),
            55, UPLOAD_ERR_OK );
    }

    protected function getMockFile()
    {
        return MockFile::init('foo', 'text1.txt', 'text/plain',
            realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, 'data', 'testing.1.txt'])),
            13, UPLOAD_ERR_OK );
    }

    protected function getMockNoFile()
    {
        return MockFile::init('foo', 'text0.txt', 'text/plain',
            '', 26, UPLOAD_ERR_NO_FILE );
    }
}


class MockEntry implements Interfaces\IValidate
{
    use TRules;

    protected $mockKey = '';
    protected $mockValue = '';

    protected function whichFactory(): Interfaces\IRuleFactory
    {
        return new Rules\Factory();
    }

    public static function init(string $key, $value): self
    {
        $lib = new static();
        return $lib->setData($key, $value);
    }

    public function setData(string $key, $value): self
    {
        $this->mockKey = $key;
        $this->mockValue = $value;
        return $this;
    }

    public function getKey(): string
    {
        return $this->mockKey;
    }

    public function getValue()
    {
        return $this->mockValue;
    }
}


class MockFile implements Interfaces\IValidateFile
{
    use TRules;

    protected $mockKey = '';
    protected $mockValue = '';
    protected $mockMime = '';
    protected $mockName = '';
    protected $mockSize = 0;
    protected $mockError = 0;

    protected function whichFactory(): Interfaces\IRuleFactory
    {
        return new Rules\File\Factory();
    }

    public static function init(string $key, string $value, string $mime, string $name, int $size, int $error): self
    {
        $lib = new static();
        return $lib->setData($key, $value, $mime, $name, $size, $error);
    }

    public function setData(string $key, $value, string $mime, string $name, int $size, int $error): self
    {
        $this->mockKey = $key;
        $this->mockValue = $value;
        $this->mockMime = $mime;
        $this->mockName = $name;
        $this->mockSize = $size;
        $this->mockError = $error;
        return $this;
    }

    public function getKey(): string
    {
        return $this->mockKey;
    }

    public function getValue()
    {
        return $this->mockValue;
    }

    public function getMimeType(): string
    {
        return $this->mockMime;
    }

    public function getTempName(): string
    {
        return $this->mockName;
    }

    public function getError(): int
    {
        return $this->mockError;
    }

    public function getSize(): int
    {
        return $this->mockSize;
    }
}

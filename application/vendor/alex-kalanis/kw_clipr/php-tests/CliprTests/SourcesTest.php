<?php

namespace CliprTests;


use CommonTestClass;
use kalanis\kw_clipr\Clipr\Sources;
use kalanis\kw_input\Interfaces\IEntry;


class SourcesTest extends CommonTestClass
{
    /**
     * @param bool $isWeb
     * @param string $entryType
     * @param string $family
     * @dataProvider entryTypeProvider
     */
    public function testEntryType(bool $isWeb, string $entryType, string $family): void
    {
        $instance = new ExtSources();
        $instance->setFamily($family);
        $instance->determineInput($isWeb);
        $this->assertTrue(in_array($entryType, $instance->getEntryTypes()));
    }

    public function entryTypeProvider(): array
    {
        return [
            [false, IEntry::SOURCE_CLI, 'Linux'],
            [false, IEntry::SOURCE_FILES, 'Linux'],
            [true, IEntry::SOURCE_GET, 'Windows'],
            [true, IEntry::SOURCE_POST, 'Windows'],
            [true, IEntry::SOURCE_FILES, 'Windows'],
            [false, IEntry::SOURCE_FILES, 'Linux'],
            [false, IEntry::SOURCE_FILES, 'MacOS'],
        ];
    }

    /**
     * @param bool $isWeb
     * @param bool $noColor
     * @param string $instanceName
     * @param string $family
     * @dataProvider outputProvider
     */
    public function testOutput(bool $isWeb, bool $noColor, string $instanceName, string $family): void
    {
        $instance = new ExtSources();
        $instance->setFamily($family);
        $instance->determineInput($isWeb, $noColor);
        $this->assertInstanceOf($instanceName, $instance->getOutput());
    }

    public function outputProvider(): array
    {
        return [
            [false, true, '\kalanis\kw_clipr\Output\Clear', 'Linux'],
            [true, false, '\kalanis\kw_clipr\Output\Web', 'Linux'],
            [false, false, '\kalanis\kw_clipr\Output\Windows', 'Windows'],
            [false, false, '\kalanis\kw_clipr\Output\Posix', 'BSD'],
            [false, false, '\kalanis\kw_clipr\Output\Clear', 'MacOS'],
        ];
    }
}


class ExtSources extends Sources
{
    /**
     * @var string
     * could be following:
     * 'Windows'
     * 'BSD'
     * 'Linux'
     * 'Solaris'
     */
    protected $xFamily = '';

    public function setFamily(string $family): self
    {
        $this->xFamily = $family;
        return $this;
    }

    protected function getFamily(): string
    {
        return $this->xFamily;
    }
}

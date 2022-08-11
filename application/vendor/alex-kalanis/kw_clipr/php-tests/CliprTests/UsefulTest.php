<?php

namespace CliprTests;


use CommonTestClass;
use kalanis\kw_clipr\Clipr\DummyEntry;
use kalanis\kw_clipr\Clipr\Useful;
use kalanis\kw_input\Entries\Entry;


class UsefulTest extends CommonTestClass
{
    public function testNth(): void
    {
        $data = [
            DummyEntry::init('no-color', true),
            DummyEntry::init('param_1', 'gjd'),
            DummyEntry::init('no-headers', false),
            DummyEntry::init('param_3', 'ceeg'),
            DummyEntry::init('param_0', 'ybh'),
            DummyEntry::init('output-file', '/tmp/clipr_test_out.txt'),
        ];
        $this->assertEquals('ceeg', Useful::getNthParam($data, 3));
        $this->assertEquals(null, Useful::getNthParam($data, 6));
    }

    /**
     * @param string $inputOne
     * @param string $wantedClass
     * @dataProvider sanitizeProvider
     */
    public function testSanitizeClass(string $inputOne, string $wantedClass): void
    {
        $this->assertEquals($wantedClass, Useful::sanitizeClass($inputOne));
    }

    public function sanitizeProvider(): array
    {
        return [
            ['kw_clipr:Clipr/Useful', 'kw_clipr\Clipr\Useful'],
            ['Interfaces\ILoader', 'Interfaces\ILoader'],
            ['\Variables', 'Variables'],
        ];
    }

    /**
     * @param object $inputOne
     * @param string $wantedClass
     * @dataProvider taskCallProvider
     */
    public function testTaskCall(object $inputOne, string $wantedClass): void
    {
        $this->assertEquals($wantedClass, Useful::getTaskCall($inputOne));
    }

    public function taskCallProvider(): array
    {
        return [
            [DummyEntry::init('', ''), 'kalanis/kw_clipr/Clipr/DummyEntry'],
            [new Entry(), 'kalanis/kw_input/Entries/Entry'],
        ];
    }
}

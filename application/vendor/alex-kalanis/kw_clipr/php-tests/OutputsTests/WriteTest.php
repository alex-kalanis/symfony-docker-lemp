<?php

namespace OutputsTests;


use CommonTestClass;
use kalanis\kw_clipr\Output;


class WriteTest extends CommonTestClass
{
    public function testQuiet(): void
    {
        $instance = new XWrite(new Output\Windows());
        $instance->setQuiet(true);
        ob_start();
        $instance->write('asdfghjkl');
        $output = trim(ob_get_clean());
        $this->assertEmpty($output);
    }

    /**
     * @param string $method
     * @param string $content
     * @param string $expected
     * @dataProvider callsProvider
     */
    public function testCalls(string $method, string $content, string $expected): void
    {
        $instance = new XWrite(new Output\Windows());
        ob_start();
        $instance->$method($content);
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }

    public function callsProvider(): array
    {
        return [
            ['sendCustom', 'QUOTE', ' .... [ QUOTE ]'],
            ['sendFailExplain', 'Died', " .... [ \e[31mFAIL\e[0m ] Died"],
            ['sendErrorMessage', 'Died', "\r\n \e[41m        \e[0m\r\n \e[41m  Died  \e[0m\r\n \e[41m        \e[0m\r\n\r\n"],
            ['sendSuccessMessage', 'Born', "\r\n \e[42m        \e[0m\r\n \e[42m  Born  \e[0m\r\n \e[42m        \e[0m\r\n\r\n"],
            ['writeHeadlineLn', 'Initial', "\e[32mInitial\e[0m\r\n\e[32m-------\e[0m\r\n"],
            ['writePadded', 'padded', 'padded'],
            ['writePaddedLn', 'padded', "padded\r\n"],
        ];
    }

    /**
     * @param string $method
     * @param string $expected
     * @dataProvider callsNoMessageProvider
     */
    public function testCallsNoMessage(string $method, string $expected): void
    {
        $instance = new XWrite(new Output\Windows());
        ob_start();
        $instance->$method();
        $output = ob_get_clean();
        $this->assertEquals($expected, $output);
    }

    public function callsNoMessageProvider(): array
    {
        return [
            ['sendOk', " .... [ \e[32mOK\e[0m ]"],
            ['sendSkipped', " .... [ \e[93mSKIPPED\e[0m ]"],
            ['sendWarning', " .... [ \e[93mWARNING\e[0m ]"],
            ['sendFail', " .... [ \e[31mFAIL\e[0m ]"],
        ];
    }

    public function testWorking(): void
    {
        $instance = new XWrite(new Output\Windows());
        foreach ($this->workingProvider() as list($method, $expected)) {
            ob_start();
            $instance->$method();
            $output = ob_get_clean();
            $this->assertEquals($expected, $output);
        }
    }

    public function workingProvider(): array
    {
        return [
            ['sendWorking', "\e[1D/"],
            ['sendWorking', "\e[1D-"],
            ['sendWorking', "\e[1D\\"],
            ['sendWorking', "\e[1D|"],
            ['sendWorking', "\e[1D/"],
            ['sendWorking', "\e[1D-"],
            ['sendWorking', "\e[1D\\"],
            ['sendWorking', "\e[1D|"],
            ['resetWorking', "\e[1D"],
            ['sendWorking', "\e[1D/"],
            ['sendWorking', "\e[1D-"],
            ['removeLastOutput', "\e[1D \e[1D"],
        ];
    }

//    public function testCallExcept()
//    {
//        $instance = new XWrite(new Output\Windows());
//        ob_start();
//        $this->expectException(CliprException::class);
//        $instance->writeHeadlineLn('asdfghjkl');
//        $output = ob_get_clean();
//        $this->assertEquals('', $output);
//    }
}


class XWrite
{
    use Output\TWrite;

    protected $translator = null;
    protected $quiet = false;

    public function __construct(Output\AOutput $translator)
    {
        $this->translator = $translator;
    }

    public function setQuiet(bool $quiet): void
    {
        $this->quiet = $quiet;
    }

    protected function getTranslator(): Output\AOutput
    {
        return $this->translator;
    }
}

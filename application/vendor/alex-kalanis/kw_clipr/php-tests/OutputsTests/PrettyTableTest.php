<?php

namespace OutputsTests;


use CommonTestClass;
use kalanis\kw_clipr\Output;


class PrettyTableTest extends CommonTestClass
{
    public function testSimple(): void
    {
        $instance = new XPrettyTable();
        $this->assertEmpty($instance->getTable()->getHeader());
        $this->assertEmpty($instance->getTable()->getSeparator());
        $instance->setTableHeaders(['poi', 'uzt']);
        $instance->setTableDataLine(['mnbv','lkjhg']);
        $instance->dumpTable();
        $this->assertEquals('| ---- | ----- |'
            . PHP_EOL . '| poi  | uzt   |'
            . PHP_EOL . '| ---- | ----- |'
            . PHP_EOL . '| mnbv | lkjhg |'
            . PHP_EOL . '| ---- | ----- |' . PHP_EOL, $instance->getLine());
        $instance->clearLine();
    }

    public function testColored(): void
    {
        $instance = new XPrettyTable();
        $instance->setTableColors(['abc', 'def']);
        $instance->setTableHeaders(['poi', 'uzt']);
        $instance->setTableColorsHeader(['okm', 'ijn']);
        $instance->setTableDataLine(['mnbv','lkjhg']);
        $instance->dumpTable();
        $this->assertEquals('| <okm>----</okm> | <ijn>-----</ijn> |'
            . PHP_EOL . '| <okm>poi </okm> | <ijn>uzt  </ijn> |'
            . PHP_EOL . '| <okm>----</okm> | <ijn>-----</ijn> |'
            . PHP_EOL . '| <abc>mnbv</abc> | <def>lkjhg</def> |'
            . PHP_EOL . '| <okm>----</okm> | <ijn>-----</ijn> |' . PHP_EOL, $instance->getLine());
        $instance->clearLine();
    }

    public function testDetails(): void
    {
        $instance = new XPrettyTable();
        $instance->setTableColors(['abc', 'def']);
        $instance->setTableHeaders(['poi', 'uzt']);
        $instance->setTableColorsHeader(['okm', 'ijn']);
        $instance->setTableDataLine(['mnbv','lkjhg']);
        $instance->getTable()->setColor(2, 'tre');
        $instance->getTable()->setHeader(2, 'vgz');
        $instance->getTable()->setColorHeader(2, 'tre');
        $instance->getTable()->prev();
        $instance->getTable()->setData(2, 'xdzhf');
        $instance->getTable()->next();
        $instance->dumpTable();
        $this->assertEquals('| <okm>----</okm> | <ijn>-----</ijn> | <tre>-----</tre> |'
            . PHP_EOL . '| <okm>poi </okm> | <ijn>uzt  </ijn> | <tre>vgz  </tre> |'
            . PHP_EOL . '| <okm>----</okm> | <ijn>-----</ijn> | <tre>-----</tre> |'
            . PHP_EOL . '| <abc>mnbv</abc> | <def>lkjhg</def> | <tre>xdzhf</tre> |'
            . PHP_EOL . '| <okm>----</okm> | <ijn>-----</ijn> | <tre>-----</tre> |' . PHP_EOL, $instance->getLine());
        $instance->clearLine();
    }
}


class XPrettyTable
{
    use Output\TPrettyTable;

    protected $line = '';

    public function writeLn(string $output = ''): void
    {
        $this->line .= $output . PHP_EOL;
    }

    public function getLine(): string
    {
        return $this->line;
    }

    public function clearLine(): void
    {
        $this->line = '';
    }

    public function getTable(): Output\PrettyTable
    {
        $this->init();
        return $this->prettyTable;
    }
}

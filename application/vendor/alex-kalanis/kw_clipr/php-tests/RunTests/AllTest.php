<?php

namespace RunTests;


use clipr\Help;
use clipr\Info;
use clipr\Lister;
use CommonTestClass;
use kalanis\kw_clipr\Clipr\DummyEntry;
use kalanis\kw_clipr\Clipr\Paths;
use kalanis\kw_clipr\CliprException;
use kalanis\kw_clipr\Interfaces\ILoader;
use kalanis\kw_clipr\Loaders\KwLoader;
use kalanis\kw_clipr\Output\Clear;
use kalanis\kw_clipr\Tasks\ATask;
use kalanis\kw_input\Filtered\EntryArrays;


class AllTest extends CommonTestClass
{
    public function testInfo(): void
    {
        // init
        $lib = new Info();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
        ]), new XLoader());
        $this->assertEquals('Info about Clipr and its inputs', $lib->desc());
        // process
        $lib->process();
        $this->assertNotNull($lib);
    }

    public function testHelp(): void
    {
        // init
        $lib = new Help();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
            DummyEntry::init('param_2', 'test'),
        ]), new XLoader());
        $this->assertEquals('Help with Clipr tasks', $lib->desc());
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    public function testHelpNoLoader(): void
    {
        // init
        $lib = new Help();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('quiet', '1'), // full variant
        ]), null);
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    public function testHelpNoTask(): void
    {
        // init
        $lib = new Help();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''), // short variant
        ]), new XLoader());
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    public function testLister(): void
    {
        // init
        $lib = new Lister();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
        ]), new XLoader());
        $this->assertEquals('Render list of tasks available in paths defined for lookup', $lib->desc());
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    public function testListerNoLoader(): void
    {
        // init
        $lib = new Lister();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
        ]), null);
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    /**
     * @throws CliprException
     */
    public function testListerPath(): void
    {
        Paths::getInstance()->addPath('data', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        // init
        $lib = new Lister();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
            DummyEntry::init('path', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data'),
        ]), new KwLoader());
        $this->assertEquals('Render list of tasks available in paths defined for lookup', $lib->desc());
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    public function testListerBadPath(): void
    {
        // init
        $lib = new Lister();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
            DummyEntry::init('path', 'test'),
        ]), new XLoader());
        $this->assertEquals('Render list of tasks available in paths defined for lookup', $lib->desc());
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }

    public function testListerNoFiles(): void
    {
        // init
        $lib = new Lister();
        $lib->initTask(new Clear(), new EntryArrays([
            DummyEntry::init('q', ''),
            DummyEntry::init('path', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'no-data'),
        ]), new XLoader());
        $this->assertEquals('Render list of tasks available in paths defined for lookup', $lib->desc());
        $this->assertNotNull($lib);
        // process
        $lib->process();
    }
}


class XTask extends ATask
{
    public function process(): void
    {
        // nothing
    }

    public function desc(): string
    {
        return 'testing task';
    }
}


class XLoader implements ILoader
{
    public function getTask(string $classFromParam): ?ATask
    {
        return 'test' == $classFromParam ? new XTask() : null ;
    }
}

<?php

namespace CliprTests;


use CommonTestClass;
use kalanis\kw_clipr\Clipr;
use kalanis\kw_clipr\CliprException;
use kalanis\kw_clipr\Interfaces\ILoader;
use kalanis\kw_clipr\Loaders\KwLoader;
use kalanis\kw_clipr\Tasks\ATask;
use kalanis\kw_input\Inputs;
use kalanis\kw_input\Variables;


class SystemTest extends CommonTestClass
{
    /**
     * @throws CliprException
     */
    public function testSimple(): void
    {
        $inputs = new Inputs();
        $inputs->setSource([
            '--no-color',
            '--no-headers',
            '--output-file=/tmp/clipr_test_out.txt',
        ])->loadEntries();
        $lib = new Clipr(
            new KwLoader(),
            new Clipr\Sources(),
            new Variables($inputs)
        );
        $lib->addPath('clipr', implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'run']));
        $this->assertNotEmpty($lib);
        $lib->run();

        /** @scrutinizer ignore-unhandled */ @unlink('/tmp/clipr_test_out.txt');
    }

    /**
     * @throws CliprException
     */
    public function testNoTask(): void
    {
        $inputs = new Inputs();
        $inputs->setSource([
            '--no-color',
        ])->loadEntries();
        $lib = new Clipr(
            new XFLoader(), // loader which returns no task
            new Clipr\Sources(),
            new Variables($inputs)
        );
        $lib->addPath('clipr', implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'run']));
        $this->expectException(CliprException::class);
        $lib->run();
    }
}


class XFLoader implements ILoader
{
    public function getTask(string $classFromParam): ?ATask
    {
        return null; // nothing found
    }
}
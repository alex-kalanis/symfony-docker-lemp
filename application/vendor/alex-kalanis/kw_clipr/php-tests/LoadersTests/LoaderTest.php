<?php

namespace LoadersTests;


use CommonTestClass;
use kalanis\kw_clipr\CliprException;
use kalanis\kw_clipr\Interfaces\ILoader;
use kalanis\kw_clipr\Loaders\CacheLoader;
use kalanis\kw_clipr\Loaders\MultiLoader;
use kalanis\kw_clipr\Tasks\ATask;


class LoaderTest extends CommonTestClass
{
    /**
     * @throws CliprException
     */
    public function testCache(): void
    {
        $lib = CacheLoader::init(new XLoader());
        $instance1 = $lib->getTask('test');
        $this->assertInstanceOf('\kalanis\kw_clipr\Tasks\ATask', $instance1);
        $instance2 = $lib->getTask('test');
        $this->assertTrue($instance1 === $instance2);
        $instance3 = $lib->getTask('nope');
        $this->assertNull($instance3);
    }

    /**
     * @throws CliprException
     */
    public function testMulti(): void
    {
        $lib = MultiLoader::init();
        $lib->addLoader(new XLoader());
        $instance1 = $lib->getTask('test');
        $this->assertInstanceOf('\kalanis\kw_clipr\Tasks\ATask', $instance1);
        $instance3 = $lib->getTask('nope');
        $this->assertNull($instance3);
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

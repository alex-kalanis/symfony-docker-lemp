<?php

use kalanis\kw_input\Interfaces\IEntry;
use kalanis\kw_input\Loaders;
use kalanis\kw_input\Parsers;


class LoaderTest extends CommonTestClass
{
    public function testFactory()
    {
        $factory = new Loaders\Factory();
        $loader1 = $factory->getLoader(IEntry::SOURCE_GET);
        $loader2 = $factory->getLoader(IEntry::SOURCE_GET); // intentionally same
        $loader3 = $factory->getLoader(IEntry::SOURCE_FILES);

        $this->assertInstanceOf('\kalanis\kw_input\Loaders\Entry', $loader1);
        $this->assertInstanceOf('\kalanis\kw_input\Loaders\Entry', $loader2);
        $this->assertInstanceOf('\kalanis\kw_input\Loaders\File', $loader3);
        $this->assertEquals($loader1, $loader2);
        $this->assertNotEquals($loader3, $loader2);
    }

    public function testEntry()
    {
        $data = new Loaders\Entry();
        $this->assertInstanceOf('\kalanis\kw_input\Loaders\ALoader', $data);

        $dataset = $this->entryDataset();
        $entries = $data->loadVars(IEntry::SOURCE_GET, $dataset);

        $entry = reset($entries);
        $this->assertEquals(IEntry::SOURCE_GET, $entry->getSource());
        $this->assertEquals('foo', $entry->getKey());
        $this->assertEquals('val1', $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_GET, $entry->getSource());
        $this->assertEquals('bar', $entry->getKey());
        $this->assertEquals(['bal1', 'bal2'], $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_GET, $entry->getSource());
        $this->assertEquals('baz', $entry->getKey());
        $this->assertEquals(true, $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_GET, $entry->getSource());
        $this->assertEquals('aff', $entry->getKey());
        $this->assertEquals(42, $entry->getValue());
    }

    public function testFile()
    {
        $data = new Loaders\File();
        $this->assertInstanceOf('\kalanis\kw_input\Loaders\ALoader', $data);

        $dataset = $this->fileDataset();
        $entries = $data->loadVars(IEntry::SOURCE_FILES, $dataset);

        $entry = reset($entries);
        $this->assertEquals(IEntry::SOURCE_FILES, $entry->getSource());
        $this->assertEquals('files', $entry->getKey());
        $this->assertEquals('facepalm.jpg', $entry->getValue());
        $this->assertEquals('image/jpeg', $entry->getMimeType());
        $this->assertEquals('/tmp/php3zU3t5', $entry->getTempName());
        $this->assertEquals(UPLOAD_ERR_OK, $entry->getError());
        $this->assertEquals(591387, $entry->getSize());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_FILES, $entry->getSource());
        $this->assertEquals('download[file1]', $entry->getKey());
        $this->assertEquals('MyFile.txt', $entry->getValue());
        $this->assertEquals('text/plain', $entry->getMimeType());
        $this->assertEquals('/tmp/php/phpgj46fg', $entry->getTempName());
        $this->assertEquals(UPLOAD_ERR_CANT_WRITE, $entry->getError());
        $this->assertEquals(816, $entry->getSize());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_FILES, $entry->getSource());
        $this->assertEquals('download[file2]', $entry->getKey());
        $this->assertEquals('MyFile.jpg', $entry->getValue());
        $this->assertEquals('image/jpeg', $entry->getMimeType());
        $this->assertEquals('/tmp/php/php7s4ag4', $entry->getTempName());
        $this->assertEquals(UPLOAD_ERR_PARTIAL, $entry->getError());
        $this->assertEquals(3075, $entry->getSize());
    }

    public function testCliFile()
    {
        $data = new Loaders\CliEntry();
        $this->assertInstanceOf('\kalanis\kw_input\Loaders\ALoader', $data);

        $cli = new Parsers\Cli();
        $dataset = $this->cliDataset();
        $entries = $data->loadVars(IEntry::SOURCE_CLI, $cli->parseInput($dataset));

        $entry = reset($entries);
        $this->assertEquals(IEntry::SOURCE_CLI, $entry->getSource());
        $this->assertEquals('testing', $entry->getKey());
        $this->assertEquals('foo', $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_CLI, $entry->getSource());
        $this->assertEquals('bar', $entry->getKey());
        $this->assertEquals(['baz', 'eek'], $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_CLI, $entry->getSource());
        $this->assertEquals('mko', $entry->getKey());
        $this->assertEquals('', $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_CLI, $entry->getSource());
        $this->assertEquals('der', $entry->getKey());
        $this->assertEquals(true, $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_FILES, $entry->getSource());
        $this->assertEquals('file1', $entry->getKey());
        $this->assertEquals('./data/tester.gif', $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_FILES, $entry->getSource());
        $this->assertEquals('file2', $entry->getKey());
        $this->assertEquals('data/testing.1.txt', $entry->getValue());

        $entry = next($entries);
        $this->assertEquals(IEntry::SOURCE_CLI, $entry->getSource());
        $this->assertEquals('file3', $entry->getKey());
        $this->assertEquals('./data/testing.2.txt', $entry->getValue());
    }
}

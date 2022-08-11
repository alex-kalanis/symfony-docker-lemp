<?php

use kalanis\kw_input\Interfaces\IEntry;
use kalanis\kw_input\Parsers;


class ParserTest extends CommonTestClass
{
    public function testFactory()
    {
        $factory = new Parsers\Factory();
        $loader1 = $factory->getLoader(IEntry::SOURCE_GET);
        $loader2 = $factory->getLoader(IEntry::SOURCE_GET); // intentionally same
        $loader3 = $factory->getLoader(IEntry::SOURCE_CLI);
        $loader4 = $factory->getLoader(IEntry::SOURCE_FILES);

        $this->assertInstanceOf('\kalanis\kw_input\Parsers\Basic', $loader1);
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\Basic', $loader2);
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\Files', $loader4);
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\Cli', $loader3);
        $this->assertEquals($loader1, $loader2);
        $this->assertNotEquals($loader3, $loader2);
        $this->assertNotEquals($loader3, $loader4);
        $this->assertNotEquals($loader2, $loader4);
    }

    public function testBasic()
    {
        $data = new Parsers\Basic();
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\AParser', $data);

        $dataset = $this->entryDataset();
        $entries = $data->parseInput($dataset);

        $entry = reset($entries);
        $this->assertEquals('foo', key($entries));
        $this->assertEquals('val1', $entry);

        $entry = next($entries);
        $this->assertEquals('bar', key($entries));
        $this->assertEquals(['bal1', 'bal2'], $entry);

        $entry = next($entries);
        $this->assertEquals('baz', key($entries));
        $this->assertEquals(true, $entry);

        $entry = next($entries);
        $this->assertEquals('aff', key($entries));
        $this->assertEquals(42, $entry);
    }

    public function testStrange()
    {
        $data = new Parsers\Basic();
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\AParser', $data);

        $dataset = $this->strangeEntryDataset();
        $entries = $data->parseInput($dataset);

        $entry = reset($entries);
        $this->assertEquals('foo  ', key($entries));
        $this->assertEquals('val1', $entry);

        $entry = next($entries);
        $this->assertEquals('bar', key($entries));
        $this->assertEquals(["<script>alert('XSS!!!')</script>", 'bal2'], $entry);

        $entry = next($entries);
        $this->assertEquals('b<a>z', key($entries));
        $this->assertEquals(false, $entry);

        $entry = next($entries);
        $this->assertEquals('a**ff', key($entries));
        $this->assertEquals('<?php echo "ded!";', $entry);
    }

    public function testFile()
    {
        $data = new Parsers\Files();
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\AParser', $data);

        $dataset = $this->fileDataset();
        $entries = $data->parseInput($dataset);

        $this->assertEquals($dataset, $entries);
    }

    public function testStrangeFile()
    {
        $data = new Parsers\Files();
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\AParser', $data);

        $dataset = $this->strangeFileDataset();
        $entries = $data->parseInput($dataset);

        $entry = reset($entries);
        $this->assertEquals('files', key($entries));
        $this->assertEquals([ // simple upload
            'name' => 'facepalm.jpg',
            'type' => 'image<?= \'/\'; ?>jpeg',
            'tmp_name' => '/tmp/php3zU3t5',
            'error' => UPLOAD_ERR_OK,
            'size' => '591387',
        ], $entry);

        $entry = next($entries);
        $this->assertEquals('download', key($entries));
        $this->assertEquals([
            'file1' => 'C:\System\MyFile.txt',
            'file2' => 'A:\MyFile.jpg',
        ], $entry['name']);
    }

    public function testCli()
    {
        $data = new Parsers\Cli();
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\AParser', $data);

        $dataset = $this->cliDataset();
        $entries = $data->parseInput($dataset);

        $entry = reset($entries);
        $this->assertEquals('testing', key($entries));
        $this->assertEquals('foo', $entry);
        $entry = next($entries);
        $this->assertEquals('bar', key($entries));
        $this->assertEquals(['baz', 'eek'], $entry);
        $entry = next($entries);
        $this->assertEquals('mko', key($entries));
        $this->assertEquals('', $entry);
        $entry = next($entries);
        $this->assertEquals('der', key($entries));
        $this->assertEquals(true, $entry);
        $entry = next($entries);
        $this->assertEquals('file1', key($entries));
        $this->assertEquals('./data/tester.gif', $entry);
        $entry = next($entries);
        $this->assertEquals('file2', key($entries));
        $this->assertEquals('data/testing.1.txt', $entry);
        $entry = next($entries);
        $this->assertEquals('file3', key($entries));
        $this->assertEquals('./data/testing.2.txt', $entry);
        $entry = next($entries);
        $this->assertEquals('a', key($entries));
        $entry = next($entries);
        $this->assertEquals('b', key($entries));
        $entry = next($entries);
        $this->assertEquals('c', key($entries));
        $entry = next($entries);
        $this->assertEquals('known', $entry);
        $entry = next($entries);
        $this->assertEquals('what', $entry);
    }

    public function testStrangeCli()
    {
        $data = new Parsers\Cli();
        $this->assertInstanceOf('\kalanis\kw_input\Parsers\AParser', $data);

        $dataset = $this->strangeCliDataset();
        $entries = $data->parseInput($dataset);

        $entry = reset($entries);
        $this->assertEquals('testing', key($entries));
        $this->assertEquals('f<o>o', $entry);
        $entry = next($entries);
        $this->assertEquals('-bar', key($entries));
        $this->assertEquals('b**a**z', $entry);
        $entry = next($entries);
        $this->assertEquals('a', key($entries));
        $entry = next($entries);
        $this->assertEquals('c', key($entries));
    }
}

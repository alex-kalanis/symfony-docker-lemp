<?php

use kalanis\kw_input\Entries;
use kalanis\kw_input\Filtered;
use kalanis\kw_input\Input;
use kalanis\kw_input\Inputs;
use kalanis\kw_input\Interfaces;


class FilteredTest extends CommonTestClass
{
    public function testBasics()
    {
        $input = new MockInputs();
        $input->setSource($this->cliDataset()); // direct cli
        $variables = new Filtered\Variables($input);

        $source = new MockSource();
        $source->setRemotes($this->entryDataset(), null, $this->cliDataset());
        $input->setSource($source)->loadEntries();

        $this->assertNotEmpty(iterator_to_array($input->getCli()));
        $this->assertNotEmpty(iterator_to_array($input->getGet()));
        $this->assertEmpty(iterator_to_array($input->getPost()));
        $this->assertEmpty(iterator_to_array($input->getSession()));
        $this->assertEmpty(iterator_to_array($input->getCookie()));
        $this->assertNotEmpty(iterator_to_array($input->getFiles())); // seems strange, but there are files from Cli
        $this->assertEmpty(iterator_to_array($input->getServer()));
        $this->assertEmpty(iterator_to_array($input->getEnv()));
        $this->assertNotEmpty(iterator_to_array($input->getBasic()));
        $this->assertEmpty(iterator_to_array($input->getSystem()));
        $this->assertEmpty(iterator_to_array($input->getExternal()));

        $entries = $variables->getInArray(null, [Interfaces\IEntry::SOURCE_GET]);
        $this->assertNotEmpty($entries);

        $entry = reset($entries);
        $this->assertEquals('foo', key($entries));
        $this->assertEquals('foo', $entry->getKey());
        $this->assertEquals('val1', $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entry->getSource());

        $entry = next($entries);
        $this->assertEquals('bar', key($entries));
        $this->assertEquals('bar', $entry->getKey());
        $this->assertEquals(['bal1', 'bal2'], $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entry->getSource());

        $entry = next($entries);
        $this->assertEquals('baz', key($entries));
        $this->assertEquals('baz', $entry->getKey());
        $this->assertEquals(true, $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entry->getSource());

        $entry = next($entries);
        $this->assertEquals('aff', key($entries));
        $this->assertEquals('aff', $entry->getKey());
        $this->assertEquals(42, $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entry->getSource());
    }

    public function testFiles()
    {
        $source = new MockSource();
        $source->setRemotes($this->entryDataset(), null, null, $this->fileDataset());

        $input = new MockInputs();
        $input->setSource($source)->loadEntries();
        $variables = new Filtered\Variables($input);

        $this->assertEmpty(iterator_to_array($input->getCli()));
        $this->assertNotEmpty(iterator_to_array($input->getGet()));
        $this->assertEmpty(iterator_to_array($input->getPost()));
        $this->assertEmpty(iterator_to_array($input->getSession()));
        $this->assertNotEmpty(iterator_to_array($input->getFiles()));
        $this->assertEmpty(iterator_to_array($input->getCookie()));
        $this->assertEmpty(iterator_to_array($input->getServer()));
        $this->assertEmpty(iterator_to_array($input->getEnv()));
        $this->assertNotEmpty(iterator_to_array($input->getBasic()));
        $this->assertEmpty(iterator_to_array($input->getSystem()));
        $this->assertEmpty(iterator_to_array($input->getExternal()));

        $entries = $variables->getInArray(null, [Interfaces\IEntry::SOURCE_FILES]);
        $this->assertNotEmpty($entries);

        $entry = reset($entries);
        $this->assertEquals('files', key($entries));
        $this->assertEquals('files', $entry->getKey());
        $this->assertEquals('facepalm.jpg', $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_FILES, $entry->getSource());

        $entry = next($entries);
        $this->assertEquals('download[file1]', key($entries));
        $this->assertEquals('download[file1]', $entry->getKey());
        $this->assertEquals('MyFile.txt', $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_FILES, $entry->getSource());

        $entry = next($entries);
        $this->assertEquals('download[file2]', key($entries));
        $this->assertEquals('download[file2]', $entry->getKey());
        $this->assertEquals('MyFile.jpg', $entry->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_FILES, $entry->getSource());
    }

    public function testObject()
    {
        $input = new MockInputs();
        $input->setSource($this->cliDataset()); // direct cli

        $source = new MockSource();
        $source->setRemotes($this->entryDataset());
        $input->setSource($source)->loadEntries();
        $variables = new Filtered\Variables($input);

        $this->assertNotEmpty(iterator_to_array($input->getGet()));

        /** @var Input $entries */
        $entries = $variables->getInObject(null, [Interfaces\IEntry::SOURCE_GET]);
        $this->assertNotEmpty(iterator_to_array($entries->getIterator()));
        $this->assertNotEmpty(count($entries));

        $this->assertTrue(isset($entries['foo']));
        $this->assertEquals('foo', $entries['foo']->getKey());
        $this->assertEquals('val1', $entries['foo']->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries['foo']->getSource());

        $this->assertTrue($entries->offsetExists('bar'));
        $this->assertEquals('bar', $entries->offsetGet('bar')->getKey());
        $this->assertEquals(['bal1', 'bal2'], $entries->offsetGet('bar')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries->offsetGet('bar')->getSource());

        $this->assertTrue(isset($entries->baz));
        $this->assertEquals('baz', $entries->baz->getKey());
        $this->assertEquals(true, $entries->baz->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries->baz->getSource());

        $this->assertTrue($entries->offsetExists('aff'));
        $this->assertEquals('aff', $entries->offsetGet('aff')->getKey());
        $this->assertEquals(42, $entries->offsetGet('aff')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries->offsetGet('aff')->getSource());

        $this->assertFalse($entries->offsetExists('uhb'));
        $entries->offsetSet('uhb', 'feaht');
        $this->assertEquals('feaht', $entries->offsetGet('uhb')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_EXTERNAL, $entries->offsetGet('uhb')->getSource());

        $entry = $entries->offsetGet('aff');
        unset($entries['aff']);
        $this->assertFalse(isset($entries['aff']));
        $entries[$entry->getKey()] = $entry;
        $this->assertTrue($entries->offsetExists('aff'));
        $entries[$entry->getKey()] = 'tfc';
        $this->assertEquals('tfc', $entries->offsetGet('aff')->getValue());

        $entry = $entries->baz;
        unset($entries->baz);
        $this->assertTrue(empty($entries->baz));
        $entries->{$entry->getKey()} = $entry;
        $this->assertTrue(isset($entries->baz));
    }

    public function testEntries()
    {
        $variables = new Filtered\EntryArrays([
            ExEntry::init(Interfaces\IEntry::SOURCE_GET, 'foo', 'val1'),
            ExEntry::init(Interfaces\IEntry::SOURCE_GET, 'bar', ['bal1', 'bal2']),
            ExEntry::init(Interfaces\IEntry::SOURCE_GET, 'baz', true),
            ExEntry::init(Interfaces\IEntry::SOURCE_GET, 'aff', 42),
            ExEntry::init(Interfaces\IEntry::SOURCE_EXTERNAL, 'uhb', 'feaht'),
        ]);

        /** @var Input $entries */
        $entries = $variables->getInObject(null, [Interfaces\IEntry::SOURCE_GET]);
        $this->assertNotEmpty(iterator_to_array($entries->getIterator()));
        $this->assertNotEmpty(count($entries));

        $this->assertTrue(isset($entries['foo']));
        $this->assertEquals('foo', $entries['foo']->getKey());
        $this->assertEquals('val1', $entries['foo']->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries['foo']->getSource());

        $this->assertTrue($entries->offsetExists('bar'));
        $this->assertEquals('bar', $entries->offsetGet('bar')->getKey());
        $this->assertEquals(['bal1', 'bal2'], $entries->offsetGet('bar')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries->offsetGet('bar')->getSource());

        $this->assertTrue(isset($entries->baz));
        $this->assertEquals('baz', $entries->baz->getKey());
        $this->assertEquals(true, $entries->baz->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries->baz->getSource());

        $this->assertTrue($entries->offsetExists('aff'));
        $this->assertEquals('aff', $entries->offsetGet('aff')->getKey());
        $this->assertEquals(42, $entries->offsetGet('aff')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_GET, $entries->offsetGet('aff')->getSource());

        $this->assertFalse($entries->offsetExists('uhb'));
        $entries->offsetSet('uhb', 'feaht');
        $this->assertEquals('feaht', $entries->offsetGet('uhb')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_EXTERNAL, $entries->offsetGet('uhb')->getSource());
    }

    public function testSimpleArray()
    {
        $variables = new Filtered\SimpleArrays([
            'foo' => 'val1',
            'bar' => ['bal1', 'bal2'],
            'baz' => true,
            'aff' => 42,
        ], Interfaces\IEntry::SOURCE_POST);

        /** @var Input $entries */
        $entries = $variables->getInObject(null, [Interfaces\IEntry::SOURCE_GET]); // sources have no meaning here
        $this->assertNotEmpty(iterator_to_array($entries->getIterator()));
        $this->assertNotEmpty(count($entries));

        $this->assertTrue(isset($entries['foo']));
        $this->assertEquals('foo', $entries['foo']->getKey());
        $this->assertEquals('val1', $entries['foo']->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_POST, $entries['foo']->getSource());

        $this->assertTrue($entries->offsetExists('bar'));
        $this->assertEquals('bar', $entries->offsetGet('bar')->getKey());
        $this->assertEquals(['bal1', 'bal2'], $entries->offsetGet('bar')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_POST, $entries->offsetGet('bar')->getSource());

        $this->assertTrue(isset($entries->baz));
        $this->assertEquals('baz', $entries->baz->getKey());
        $this->assertEquals(true, $entries->baz->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_POST, $entries->baz->getSource());

        $this->assertTrue($entries->offsetExists('aff'));
        $this->assertEquals('aff', $entries->offsetGet('aff')->getKey());
        $this->assertEquals(42, $entries->offsetGet('aff')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_POST, $entries->offsetGet('aff')->getSource());
    }

    public function testArrayAccess()
    {
        $variables = new Filtered\ArrayAccessed(new ArrayObject([
            'foo' => 'val1',
            'bar' => ['bal1', 'bal2'],
            'baz' => true,
            'aff' => 42,
        ]), Interfaces\IEntry::SOURCE_CLI);

        /** @var Input $entries */
        $entries = $variables->getInObject(null, [Interfaces\IEntry::SOURCE_GET]); // sources have no meaning here
        $this->assertNotEmpty(iterator_to_array($entries->getIterator()));
        $this->assertNotEmpty(count($entries));

        $this->assertTrue(isset($entries['foo']));
        $this->assertEquals('foo', $entries['foo']->getKey());
        $this->assertEquals('val1', $entries['foo']->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_CLI, $entries['foo']->getSource());

        $this->assertTrue($entries->offsetExists('bar'));
        $this->assertEquals('bar', $entries->offsetGet('bar')->getKey());
        $this->assertEquals(['bal1', 'bal2'], $entries->offsetGet('bar')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_CLI, $entries->offsetGet('bar')->getSource());

        $this->assertTrue(isset($entries->baz));
        $this->assertEquals('baz', $entries->baz->getKey());
        $this->assertEquals(true, $entries->baz->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_CLI, $entries->baz->getSource());

        $this->assertTrue($entries->offsetExists('aff'));
        $this->assertEquals('aff', $entries->offsetGet('aff')->getKey());
        $this->assertEquals(42, $entries->offsetGet('aff')->getValue());
        $this->assertEquals(Interfaces\IEntry::SOURCE_CLI, $entries->offsetGet('aff')->getSource());
    }
}


class MockSource implements Interfaces\ISource
{
    protected $mockCli;
    protected $mockGet;
    protected $mockPost;
    protected $mockFiles;
    protected $mockCookie;
    protected $mockSession;

    public function setRemotes(?array $get, ?array $post = null, ?array $cli = null, ?array $files = null, ?array $cookie = null, ?array $session = null): self
    {
        $this->mockCli = $cli;
        $this->mockGet = $get;
        $this->mockPost = $post;
        $this->mockFiles = $files;
        $this->mockCookie = $cookie;
        $this->mockSession = $session;
        return $this;
    }

    public function cli(): ?array
    {
        return $this->mockCli;
    }

    public function get(): ?array
    {
        return $this->mockGet;
    }

    public function post(): ?array
    {
        return $this->mockPost;
    }

    public function files(): ?array
    {
        return $this->mockFiles;
    }

    public function cookie(): ?array
    {
        return $this->mockCookie;
    }

    public function session(): ?array
    {
        return $this->mockSession;
    }

    public function server(): ?array
    {
        $content = null;
        return $content;
    }

    public function env(): ?array
    {
        $content = null;
        return $content;
    }

    public function external(): ?array
    {
        $content = null;
        return $content;
    }
}


class MockInputs extends Inputs
{
    public function getBasic(): Traversable
    {
        return $this->getIn(null, [
            Interfaces\IEntry::SOURCE_CLI,
            Interfaces\IEntry::SOURCE_GET,
            Interfaces\IEntry::SOURCE_POST,
        ]);
    }

    public function getSystem(): Traversable
    {
        return $this->getIn(null, [
            Interfaces\IEntry::SOURCE_SERVER,
            Interfaces\IEntry::SOURCE_ENV,
        ]);
    }

    public function getCli(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_CLI]);
    }

    public function getGet(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_GET]);
    }

    public function getPost(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_POST]);
    }

    public function getSession(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_SESSION]);
    }

    public function getCookie(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_COOKIE]);
    }

    public function getFiles(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_FILES]);
    }

    public function getServer(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_SERVER]);
    }

    public function getEnv(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_ENV]);
    }

    public function getExternal(): Traversable
    {
        return $this->getIn(null, [Interfaces\IEntry::SOURCE_EXTERNAL]);
    }
}


class ExEntry extends Entries\Entry
{
    public static function init(string $source, string $key, $value = null): Entries\Entry
    {
        $lib = new self();
        $lib->setEntry($source, $key, $value);
        return $lib;
    }
}

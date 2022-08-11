<?php

use kalanis\kw_forms\Adapters\AAdapter;
use kalanis\kw_forms\Adapters\FilesAdapter;
use kalanis\kw_forms\Cache\TStorage;
use kalanis\kw_storage\Interfaces\IStorage;
use PHPUnit\Framework\TestCase;


class CommonTestClass extends TestCase
{
}


class StorageTrait
{
    use TStorage;

    public function getAlias(): ?string
    {
        return 'OurAlias';
    }
}


class StorageMock implements IStorage
{
    protected $content = null;

    public function check(string $key): bool
    {
        return true;
    }

    public function exists(string $key): bool
    {
        return isset($this->content[$key]);
    }

    public function load(string $key)
    {
        return isset($this->content[$key]) ? $this->content[$key] : null ;
    }

    public function save(string $key, $data, ?int $timeout = null): bool
    {
        $this->content[$key] = $data;
        return empty($timeout);
    }

    public function remove(string $key): bool
    {
        if (isset($this->content[$key])) unset($this->content[$key]);
        return true;
    }

    public function lookup(string $key): Traversable
    {
        yield from $this->content;
    }

    public function increment(string $key): bool
    {
        return true;
    }

    public function decrement(string $key): bool
    {
        return false;
    }

    public function removeMulti(array $keys): array
    {
        return [];
    }
}


class MockArray implements ArrayAccess, Countable, Iterator
{
    protected $key = null;
    protected $vars = [];

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->current();
    }

    public function current()
    {
        return $this->valid() ? $this->offsetGet($this->key) : null ;
    }

    public function next()
    {
        next($this->vars);
        $this->key = key($this->vars);
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return $this->offsetExists($this->key);
    }

    public function rewind()
    {
        reset($this->vars);
        $this->key = key($this->vars);
    }

    public function offsetExists($offset)
    {
        return isset($this->vars[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->vars[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->vars[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->vars[$offset]);
    }

    public function count()
    {
        return count($this->vars);
    }
}


class Adapter extends AAdapter
{
    protected $vars = [
        'foo' => 'aff',
        'bar' => 'poa',
        'baz' => 'cdd',
        'sgg' => 'arr',
        'sdsrs' => 'ggsd<$=#,\'',
        'dsrsd' => 'zfd?-.!>"',
        'dg-[]' => 'dc^&#~\\€`~°',
        'dg[]' => '<?php =!@#dc^&#~',
    ];

    public function loadEntries(string $inputType): void
    {
        $entry = new \kalanis\kw_input\Entries\Entry();
        $entry->setEntry(\kalanis\kw_input\Interfaces\IEntry::SOURCE_EXTERNAL, 'xggxgx', 'lkjhdf');
        $this->vars['xggxgx'] = $entry;
    }

    public function getSource(): string
    {
        return static::SOURCE_EXTERNAL;
    }
}


class Files extends FilesAdapter
{
    public function loadEntries(string $inputType): void
    {
        parent::loadEntries($inputType);
        $dataset = $this->fileDataset();
        $this->vars = $this->loadVars($dataset);
    }

    protected function fileDataset(): array
    {
        return [
            'files' => [ // simple upload
                'name' => 'facepalm.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php3zU3t5',
                'error' => UPLOAD_ERR_OK,
                'size' => 591387,
            ],
            'download' => [ // multiple upload
                'name' => [
                    'file1' => 'MyFile.txt',
                    'file2' => 'MyFile.jpg',
                ],
                'type' => [
                    'file1' => 'text/plain',
                    'file2' => 'image/jpeg',
                ],
                'tmp_name' => [
                    'file1' => '/tmp/php/phpgj46fg',
                    'file2' => '/tmp/php/php7s4ag4',
                ],
                'error' => [
                    'file1' => UPLOAD_ERR_CANT_WRITE,
                    'file2' => UPLOAD_ERR_PARTIAL,
                ],
                'size' => [
                    'file1' => 816,
                    'file2' => 3075,
                ],
            ],
            'numbered' => [ // multiple upload
                'name' => [
                    0 => 'MyFile.txt',
                    1 => 'MyFile.jpg',
                ],
                'type' => [
                    0 => 'text/plain',
                    1 => 'image/jpeg',
                ],
                'tmp_name' => [
                    0 => '/tmp/php/phpgj46fg',
                    1 => '/tmp/php/php7s4ag4',
                ],
                'error' => [
                    0 => UPLOAD_ERR_CANT_WRITE,
                    1 => UPLOAD_ERR_PARTIAL,
                ],
                'size' => [
                    0 => 816,
                    1 => 3075,
                ],
            ],
        ];
    }

}

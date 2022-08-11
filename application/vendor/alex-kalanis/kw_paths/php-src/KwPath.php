<?php

namespace kalanis\kw_paths;


/**
 * Class KwPath
 * @package kalanis\kw_paths
 * Path as array
 */
class KwPath
{
    /** @var string[] */
    protected $path = [];

    public function __toString()
    {
        return $this->getPath();
    }

    public function setPath(string $path): self
    {
        $this->path = array_filter(array_filter(Stuff::pathToArray($path), ['\kalanis\kw_paths\Stuff', 'notDots']));
        return $this;
    }

    public function getPath(): string
    {
        return Stuff::arrayToPath($this->path);
    }

    /**
     * @return string[]
     */
    public function getArray(): array
    {
        return array_merge($this->path, []); // remove indexes
    }

    public function getDirectory(): string
    {
        return (1 < count($this->path))
            ? Stuff::arrayToPath(array_slice($this->path, 0, -1))
            : '' ;
    }

    public function getFileName(): string
    {
        return (0 < count($this->path))
            ? end($this->path)
            : '' ;
    }
}

<?php

namespace kalanis\kw_paths\Extras;


/**
 * Class DirectoryListing
 * @package kalanis\kw_paths\Extras
 * Listing through the directory
 */
class DirectoryListing
{
    /** @var string */
    protected $path = '';
    /** @var bool */
    protected $orderDesc = false;
    /** @var callable|null */
    protected $usableCallback = null;
    /** @var string[] */
    protected $files = [];

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function setOrderDesc(bool $orderDesc): self
    {
        $this->orderDesc = $orderDesc;
        return $this;
    }

    public function setUsableCallback(callable $usable): self
    {
        $this->usableCallback = $usable;
        return $this;
    }

    public function process(): self
    {
        $preList = ($this->orderDesc)
            ? (array) scandir($this->path, 1)
            : (array) scandir($this->path, 0)
        ;
        $this->files = array_filter($preList);
        if ($this->usableCallback) {
            $this->files = array_filter($this->files, $this->usableCallback);
        }
        return $this;
    }

    /**
     * @return string[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param int|null $offset
     * @param int|null $limit
     * @return string[]
     */
    public function getFilesSliced(?int $offset, ?int $limit): array
    {
        return array_slice($this->files, intval($offset), $limit);
    }
}

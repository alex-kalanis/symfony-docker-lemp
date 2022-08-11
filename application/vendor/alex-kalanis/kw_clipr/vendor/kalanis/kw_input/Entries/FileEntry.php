<?php

namespace kalanis\kw_input\Entries;


use kalanis\kw_input\Interfaces;


/**
 * Class FileEntry
 * @package kalanis\kw_input\Entries
 * Input is file and has extra values
 */
class FileEntry extends Entry implements Interfaces\IFileEntry
{
    /** @var string */
    protected $mimeType = '';
    /** @var string */
    protected $tmpName = '';
    /** @var int */
    protected $error = 0;
    /** @var int */
    protected $size = 0;

    public function setFile(string $fileName, string $tmpName, string $mimeType, int $error, int $size): self
    {
        $this->value = $fileName;
        $this->mimeType = $mimeType;
        $this->tmpName = $tmpName;
        $this->error = $error;
        $this->size = $size;
        return $this;
    }

    public function getSource(): string
    {
        return static::SOURCE_FILES;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getTempName(): string
    {
        return $this->tmpName;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}

<?php

namespace kalanis\kw_forms\Adapters;


use kalanis\kw_input\Interfaces\IFileEntry;


class FileEntry implements IFileEntry
{
    /** @var string */
    protected $key = '';
    /** @var string */
    protected $value = '';
    /** @var string */
    protected $temp = '';
    /** @var string */
    protected $mime = '';
    /** @var int */
    protected $error = 0;
    /** @var int */
    protected $size = 0;

    public function setData(string $key, string $value, string $temp, string $mime, int $error, int $size): self
    {
        $this->key = $key;
        $this->value = $value;
        $this->temp = $temp;
        $this->mime = $mime;
        $this->error = $error;
        $this->size = $size;
        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getMimeType(): string
    {
        return $this->mime;
    }

    public function getTempName(): string
    {
        return $this->temp;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getSource(): string
    {
        return static::SOURCE_FILES;
    }
}

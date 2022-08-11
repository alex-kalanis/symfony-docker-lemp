<?php

namespace kalanis\kw_input\Interfaces;


/**
 * Interface IFileEntry
 * @package kalanis\kw_input\Interfaces
 * File entry interface - how to access uploaded files
 * @link https://www.php.net/manual/en/reserved.variables.files.php
 */
interface IFileEntry extends IEntry
{
    /**
     * Return what mime is that by browser
     * Beware, it is not reliable
     * @return string
     */
    public function getMimeType(): string;

    /**
     * Get name in temp
     * Use it for function like move_uploaded_file()
     * @return string
     */
    public function getTempName(): string;

    /**
     * Get error code from upload
     * @return int
     * @link https://www.php.net/manual/en/features.file-upload.errors.php
     */
    public function getError(): int;

    /**
     * Get uploaded file size
     * @return int
     */
    public function getSize(): int;
}

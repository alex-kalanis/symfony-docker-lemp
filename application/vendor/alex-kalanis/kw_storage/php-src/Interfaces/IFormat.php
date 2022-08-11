<?php

namespace kalanis\kw_storage\Interfaces;


use kalanis\kw_storage\StorageException;


/**
 * Interface IFormat
 * @package kalanis\kw_storage\Interfaces
 * Format content into and from storage
 */
interface IFormat
{
    /**
     * @param mixed $content
     * @throws StorageException
     * @return mixed usually primitives like string or int
     */
    public function decode($content);

    /**
     * @param mixed $data usually primitives like string or int
     * @throws StorageException
     * @return mixed stored content
     */
    public function encode($data);
}

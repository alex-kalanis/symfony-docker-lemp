<?php

namespace kalanis\kw_address_handler\Sources;


/**
 * Class ASources
 * @package kalanis\kw_address_handler\Sources
 * Connect class which contains path to update to the handler
 */
class Sources
{
    /** @var string */
    protected $address = '';
    /** @var string */
    protected $path = '';

    public function __toString()
    {
        return $this->getAddress();
    }

    public function setAddress(string $address): void
    {
        // address which begins on two and more slashes might can be understand as relative one with FQDN
        $this->address = strval(preg_replace('#^(//+)#', '/', $address));
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}

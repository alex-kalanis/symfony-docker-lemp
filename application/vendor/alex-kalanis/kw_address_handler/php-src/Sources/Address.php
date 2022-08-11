<?php

namespace kalanis\kw_address_handler\Sources;


/**
 * Class Address
 * @package kalanis\kw_address_handler\Sources
 * Construct string is wanted address to parse
 */
class Address extends Sources
{
    public function __construct(string $address)
    {
        $this->setAddress($address);
    }
}

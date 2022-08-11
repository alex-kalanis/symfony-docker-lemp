<?php

namespace kalanis\kw_address_handler\Sources;


use ArrayAccess;


/**
 * Class InputArray
 * @package kalanis\kw_address_handler\Sources
 * Construct object is inputs datasource which provides the address
 */
class InputArray extends Sources
{
    public function __construct(ArrayAccess $inputs, string $entry = 'REQUEST_URI')
    {
        if ($inputs->offsetExists($entry) && '' != $inputs->offsetGet($entry)) {
            $this->setAddress(strval($inputs->offsetGet($entry)));
        }
    }
}

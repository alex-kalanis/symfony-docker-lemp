<?php

namespace kalanis\kw_paths\Params\Request;


use kalanis\kw_paths\Params\Request;


/**
 * Class ArrayAccess
 * @package kalanis\kw_paths\Params\Request
 * Input source is ArrayAccess which provides the path data
 * This one is for accessing with simplified inputs
 */
class ArrayAccess extends Request
{
    public function set(\ArrayAccess $inputs, string $key = 'REQUEST_URI', ?string $virtualDir = null): parent
    {
        if ($inputs->offsetExists($key)) {
            $this->setData(strval($inputs->offsetGet($key)), $virtualDir);
        }
        return $this;
    }
}

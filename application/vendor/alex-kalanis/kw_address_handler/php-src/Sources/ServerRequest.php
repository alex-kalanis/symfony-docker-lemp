<?php

namespace kalanis\kw_address_handler\Sources;


/**
 * Class ServerRequest
 * @package kalanis\kw_address_handler\Sources
 * Input source is Request_Uri in _SERVER variable
 * @codeCoverageIgnore access external variable
 */
class ServerRequest extends Sources
{
    public function __construct()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $this->setAddress($_SERVER['REQUEST_URI']);
        }
    }
}

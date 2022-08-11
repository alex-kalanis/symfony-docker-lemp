<?php

namespace kalanis\kw_forms\Adapters;


/**
 * Class SessionAdapter
 * @package kalanis\kw_forms\Adapters
 * Accessing _SESSION via ArrayAccess
 * Sanitize inputs
 */
class SessionAdapter extends VarsAdapter
{
    public function loadEntries(string $inputType): void
    {
        $_SESSION = $this->loadVars($_SESSION);
        $this->vars = &$_SESSION;
    }

    public function getSource(): string
    {
        return static::SOURCE_SESSION;
    }
}

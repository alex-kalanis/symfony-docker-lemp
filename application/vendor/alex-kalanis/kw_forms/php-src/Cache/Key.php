<?php

namespace kalanis\kw_forms\Cache;


use kalanis\kw_storage\Interfaces\IKey;


class Key implements IKey
{
    /** @var string */
    protected $alias = '';

    public function setAlias(string $alias = ''): void
    {
        $this->alias = $alias;
    }

    public function fromSharedKey(string $key): string
    {
        return 'FormStorage_' . $this->alias . '_' . $key;
    }
}

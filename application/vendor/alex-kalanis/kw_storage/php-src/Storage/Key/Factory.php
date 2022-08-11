<?php

namespace kalanis\kw_storage\Storage\Key;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage\Target;


class Factory
{
    public function getKey(Interfaces\IStorage $storage): Interfaces\IKey
    {
        if ($storage instanceof Target\Volume) {
            return new DirKey();
        }
        return new DefaultKey();
    }
}

<?php

namespace kalanis\kw_storage\Storage\Target;


use kalanis\kw_storage\Interfaces;


/**
 * Class Factory
 * @package kalanis\kw_storage\Storage\Target
 * Simple example of storage factory
 */
class Factory
{
    /**
     * @param mixed|object|array|string|null $params
     * @return Interfaces\IStorage|null storage adapter or empty for no storage set
     */
    public function getStorage($params): ?Interfaces\IStorage
    {
        if ($params instanceof Interfaces\IStorage) {
            return $params;
        }

        if (is_array($params)) {
            if (isset($params['storage'])) {
                if ('volume' == $params['storage']) {
                    return new Volume();
                }
                if ('none' == $params['storage']) {
                    return null;
                }
            }
        }

        if (is_string($params)) {
            if ('volume' == $params) {
                return new Volume();
            }
            if ('none' == $params) {
                return null;
            }
        }
        return null;
    }
}

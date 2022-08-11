<?php

namespace kalanis\kw_connect\core;


use kalanis\kw_connect\core\Interfaces\IFilterFactory;
use kalanis\kw_connect\core\Interfaces\IFilterType;


/**
 * Class AFactory
 * @package kalanis\kw_connect\core
 * Factory Class for accessing filter types
 */
abstract class AFilterFactory implements IFilterFactory
{
    /**
     * In child only fill this map
     * @var array<string, string>
     */
    protected static $map = [];

    public static function getInstance(): self
    {
        return new static();
    }

    final protected function __construct()
    {
    }

    /**
     * @param string $action
     * @throws ConnectException
     * @return IFilterType
     */
    public function getFilter(string $action): IFilterType
    {
        if (!isset(static::$map[$action])) {
            throw new ConnectException(sprintf('Unknown filter action *%s*!', $action));
        }
        $class = static::$map[$action];
        $lib = new $class();
        if (!$lib instanceof IFilterType) {
            throw new ConnectException(sprintf('Bad filter class *%s*!', $class));
        }
        return $lib;
    }
}

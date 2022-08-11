<?php

namespace kalanis\kw_connect\core\Interfaces;


use ArrayAccess, IteratorAggregate, Countable;


/**
 * Interface IIterableConnector
 * @package kalanis\kw_connect\Interfaces
 * Connect data source to table representation and work with it - iterable variant
 */
interface IIterableConnector extends IConnector, ArrayAccess, IteratorAggregate, Countable
{
}

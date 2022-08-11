<?php

namespace kalanis\kw_connect\core;


use kalanis\kw_connect\core\Interfaces\IRow;


/**
 * Class AConnector
 * @package kalanis\kw_connect\core
 */
abstract class AConnector extends AIterator
{
    /** @var IRow[] */
    protected $translatedData = [];

    protected function getIterableName(): string
    {
        return 'translatedData';
    }

    abstract protected function parseData(): void;

    /**
     * Get row with data by preset key
     * @param int|string $key
     * @return IRow
     */
    public function getByKey($key): ?IRow
    {
        return $this->offsetExists($key) ? $this->translatedData[$key] : null ;
    }
}

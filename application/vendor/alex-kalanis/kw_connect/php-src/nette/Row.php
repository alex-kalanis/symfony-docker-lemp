<?php

namespace kalanis\kw_connect\nette;


use kalanis\kw_connect\core\Interfaces\IRow;
use Nette\Database\IRow as NetteRow;


/**
 * Class Row
 * @package kalanis\kw_connect\nette
 */
class Row implements IRow
{
    /** @var NetteRow<string|int, string|int|float|bool|null> */
    protected $row;

    /**
     * @param NetteRow<string|int, string|int|float|bool|null> $row
     */
    public function __construct(NetteRow $row)
    {
        $this->row = $row;
    }

    public function getValue($property)
    {
        return $this->row->offsetGet($property);
    }

    public function __isset($name)
    {
        return $this->row->offsetExists($name);
    }
}

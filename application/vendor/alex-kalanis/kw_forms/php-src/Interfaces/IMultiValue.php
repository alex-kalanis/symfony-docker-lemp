<?php

namespace kalanis\kw_forms\Interfaces;


use kalanis\kw_input\Interfaces\IFileEntry;


/**
 * Interface IMultiValue
 * @package kalanis\kw_forms\Interfaces
 * When control can access multiple values
 */
interface IMultiValue
{
    /**
     * @return array<string, string|int|float|bool|IFileEntry|null>
     */
    public function getValues(): array;

    /**
     * @param array<string, string|int|float|bool|IFileEntry|null> $data
     */
    public function setValues(array $data): void;
}

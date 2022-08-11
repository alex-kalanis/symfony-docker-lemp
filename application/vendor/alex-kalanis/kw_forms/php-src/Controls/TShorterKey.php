<?php

namespace kalanis\kw_forms\Controls;


/**
 * Trait TShorterKey
 * @package kalanis\kw_forms\Controls
 * When you want access key without that array component - just basic key name
 */
trait TShorterKey
{
    protected function shorterKey(string $currentKey): string
    {
        $pre = explode('[', $currentKey);
        return strval(reset($pre));
    }
}

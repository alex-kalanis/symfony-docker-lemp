<?php

namespace kalanis\kw_paging\Interfaces;


/**
 * Interface IPGTranslations
 * @package kalanis\kw_paging\Interfaces
 * Translations
 */
interface IPGTranslations
{
    public function kpgShowResults(int $from, int $to, int $max): string;
}

<?php

namespace kalanis\kw_paging\Render;


use kalanis\kw_paging\Interfaces\IPGTranslations;


/**
 * Trait THelpingText
 * @package kalanis\kw_paging\Render\SimplifiedPager
 * Trait for render simple helping text about
 */
class Translations implements IPGTranslations
{
    public function kpgShowResults(int $from, int $to, int $max): string
    {
        return sprintf(
            'Showing results %d - %d of total %d',
            $from,
            $to,
            $max
        );
    }
}

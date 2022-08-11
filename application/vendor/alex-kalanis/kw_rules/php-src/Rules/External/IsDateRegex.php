<?php

namespace kalanis\kw_rules\Rules\External;


use kalanis\kw_rules\Rules\MatchesPattern;


/**
 * Class IsDateRegex
 * @package kalanis\kw_rules\Rules\External
 * Check if input is date for preset format (YYYY-MM-DD)
 * @codeCoverageIgnore when I wrote tests I have zero will for defining all available dates to check
 */
class IsDateRegex extends MatchesPattern
{
    protected function checkValue(/** @scrutinizer ignore-unused */ $againstValue)
    {
        return '/^(((\d{4})(-)(0[13578]|10|12)(-)(0[1-9]|[12][0-9]|3[01]))|((\d{4})(-)(0[469]|11)(-)([0][1-9]|[12][0-9]|30))|((\d{4})(-)(02)(-)(0[1-9]|1[0-9]|2[0-8]))|(([02468][048]00)(-)(02)(-)(29))|(([13579][26]00)(-)(02)(-)(29))|(([0-9][0-9][0][48])(-)(02)(-)(29))|(([0-9][0-9][2468][048])(-)(02)(-)(29))|(([0-9][0-9][13579][26])(-)(02)(-)(29)))$/iu';
    }
}

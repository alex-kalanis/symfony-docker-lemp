<?php

namespace kalanis\kw_paging\Render;


use kalanis\kw_paging\Interfaces\IPGTranslations;
use kalanis\kw_paging\Interfaces\IPositions;


/**
 * Trait THelpingText
 * @package kalanis\kw_paging\Render\SimplifiedPager
 * Trait for render simple helping text about
 */
trait THelpingText
{
    /** @var IPGTranslations|null*/
    protected $lang = null;

    public function setLang(?IPGTranslations $lang): void
    {
        $this->lang = $lang;
    }

    public function getFilledText(?IPositions $positions): string
    {
        if (!$this->lang || !$positions) {
            return '';
        }
        return $this->lang->kpgShowResults(
            $positions->getPager()->getOffset() + 1,
            min($positions->getPager()->getOffset() + $positions->getPager()->getLimit(), $positions->getPager()->getMaxResults()),
            $positions->getPager()->getMaxResults()
        );
    }
}

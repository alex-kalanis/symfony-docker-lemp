<?php

namespace kalanis\kw_paging\Render;


use kalanis\kw_pager\Interfaces\IPager;
use kalanis\kw_paging\Interfaces\IOutput;
use kalanis\kw_paging\Interfaces\IPGTranslations;
use kalanis\kw_paging\Interfaces\IPositions;


/**
 * Class CliPager
 * @package kalanis\kw_paging\Render
 * Pager for displaying on CLI
 */
class CliPager implements IOutput
{
    use TDisplayPages;
    use THelpingText;

    const SELECT_PAGE = '*';
    const NONE_PAGE = '-';
    const PREV_PAGE = '<';
    const NEXT_PAGE = '>';

    public function __construct(IPositions $positions, int $displayPages = IPositions::DEFAULT_DISPLAY_PAGES_COUNT, ?IPGTranslations $lang = null)
    {
        $this->positions = $positions;
        $this->displayPagesCount = $displayPages;
        $this->setLang($lang ?: new Translations());
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render(bool $showPositions = true): string
    {
        if (!$this->positions->prevPageExists() && !$this->positions->nextPageExists()) {
            return '';
        }
        $pages = [];

        $pages[] = $this->positions->prevPageExists() ? static::PREV_PAGE . static::PREV_PAGE . ' ' . $this->positions->getFirstPage() : static::NONE_PAGE . static::NONE_PAGE ;
        $pages[] = $this->positions->prevPageExists() ? static::PREV_PAGE . ' ' . $this->positions->getPrevPage() : static::NONE_PAGE ;
        $pages[] = $this->positions->getPager()->getActualPage() ;
        $pages[] = $this->positions->nextPageExists() ? $this->positions->getNextPage() . ' ' . static::NEXT_PAGE : static::NONE_PAGE ;
        $pages[] = $this->positions->nextPageExists() ? $this->positions->getLastPage() . ' ' . static::NEXT_PAGE . static::NEXT_PAGE : static::NONE_PAGE . static::NONE_PAGE ;

        return implode(' | ', $pages) . ($showPositions ? ( PHP_EOL . $this->getFilledText($this->positions) ) : '' );
    }

    public function getPager(): IPager
    {
        return $this->positions->getPager();
    }
}

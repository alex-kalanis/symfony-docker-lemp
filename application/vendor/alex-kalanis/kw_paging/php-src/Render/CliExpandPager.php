<?php

namespace kalanis\kw_paging\Render;


/**
 * Class CliExpandPager
 * @package kalanis\kw_paging\Render
 * Pager for displaying on CLI
 */
class CliExpandPager extends CliPager
{
    public function render(bool $showPositions = true): string
    {
        if (!$this->positions->prevPageExists() && !$this->positions->nextPageExists()) {
            return $this->getFilledText($this->positions);
        }
        $pages = [];

        $pages[] = $this->positions->prevPageExists() ? static::PREV_PAGE . static::PREV_PAGE . ' ' . $this->positions->getFirstPage() : static::NONE_PAGE . static::NONE_PAGE ;
        $pages[] = $this->positions->prevPageExists() ? static::PREV_PAGE . ' ' . $this->positions->getPrevPage() : static::NONE_PAGE ;

        foreach ($this->getDisplayPages() as $displayPage) {
            $current = ($this->positions->getPager()->getActualPage() == $displayPage);
            $pages[] = $current ? static::SELECT_PAGE . $displayPage . static::SELECT_PAGE : $displayPage ;
        }

        $pages[] = $this->positions->nextPageExists() ? $this->positions->getNextPage() . ' ' . static::NEXT_PAGE : static::NONE_PAGE ;
        $pages[] = $this->positions->nextPageExists() ? $this->positions->getLastPage() . ' ' . static::NEXT_PAGE . static::NEXT_PAGE : static::NONE_PAGE . static::NONE_PAGE ;

        return implode(' | ', $pages) . ( $showPositions ? (PHP_EOL . $this->getFilledText($this->positions) ) : '');
    }
}

<?php

namespace kalanis\kw_paging\Render;


use kalanis\kw_paging\Interfaces\IPositions;


/**
 * Trait TDisplayPages
 * @package kalanis\kw_paging\Render
 * Trait to select pages to render
 */
trait TDisplayPages
{
    /** @var int */
    protected $displayPagesCount = IPositions::DEFAULT_DISPLAY_PAGES_COUNT;

    /** @var IPositions */
    protected $positions = null;

    /**
     * Return array of page numbers, which will be rendered for current pager state. If we want another way to render, just overwrite this method.
     * @return int[]
     */
    protected function getDisplayPages()
    {
        $actualPage = $this->positions->getPager()->getActualPage(); // 2
        $count = $this->positions->getPager()->getPagesCount(); // 20
        $whole = $this->displayPagesCount; // 10

        $half = floor($whole / 2); // 5
        $tail = $count - $actualPage; // 18

        $i = ($tail > $half) ? intval($actualPage - $half) : intval($count - $whole + 1); // 3
        $result = [];

        // ++ < 10 && 3 <= 20
        while ((count($result) < $this->displayPagesCount) && ($i <= $count)) {
            if ($this->positions->getPager()->pageExists($i)) {
                $result[] = $i;
            }
            $i++;
        }

        return $result;
    }
}

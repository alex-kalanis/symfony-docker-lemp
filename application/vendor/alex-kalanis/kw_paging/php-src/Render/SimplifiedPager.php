<?php

namespace kalanis\kw_paging\Render;


use kalanis\kw_pager\Interfaces\IPager;
use kalanis\kw_paging\Interfaces\ILink;
use kalanis\kw_paging\Interfaces\IOutput;
use kalanis\kw_paging\Interfaces\IPGTranslations;
use kalanis\kw_paging\Interfaces\IPositions;


/**
 * Class SimplifiedPager
 * @package kalanis\kw_paging\Render
 * Simplified pager with less classes
 */
class SimplifiedPager implements IOutput
{
    use TDisplayPages;

    const PREV_PAGE = '&lt;';
    const NEXT_PAGE = '&gt;';

    /** @var ILink */
    protected $link = null;
    /** @var SimplifiedPager\Pager */
    protected $pager = null;
    /** @var SimplifiedPager\CurrentPage */
    protected $currentPage = null;
    /** @var SimplifiedPager\AnotherPage */
    protected $anotherPage = null;
    /** @var SimplifiedPager\DisabledPage */
    protected $disabledPage = null;

    public function __construct(IPositions $positions, ILink $link, int $displayPages = IPositions::DEFAULT_DISPLAY_PAGES_COUNT, ?IPGTranslations $lang = null)
    {
        $this->positions = $positions;
        $this->link = $link;
        $this->displayPagesCount = $displayPages;
        $this->pager = new SimplifiedPager\Pager();
        $this->pager->setLang($lang ?: new Translations());
        $this->currentPage = new SimplifiedPager\CurrentPage();
        $this->anotherPage = new SimplifiedPager\AnotherPage();
        $this->disabledPage = new SimplifiedPager\DisabledPage();
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

        $first = $this->positions->prevPageExists() ? $this->anotherPage : $this->disabledPage;
        $this->link->setPageNumber($this->positions->getFirstPage());
        $pages[] = $first->reset()->setData($this->link, static::PREV_PAGE . static::PREV_PAGE)->render();
        $this->link->setPageNumber($this->positions->getPrevPage());
        $pages[] = $first->reset()->setData($this->link, static::PREV_PAGE)->render();

        foreach ($this->getDisplayPages() as $displayPage) {
            $current = ($this->positions->getPager()->getActualPage() == $displayPage) ? $this->currentPage : $this->anotherPage ;
            $this->link->setPageNumber($displayPage);
            $pages[] = $current->reset()->setData($this->link, strval($displayPage))->render();
        }

        $last = $this->positions->nextPageExists() ? $this->anotherPage : $this->disabledPage;
        $this->link->setPageNumber($this->positions->getNextPage());
        $pages[] = $last->reset()->setData($this->link, static::NEXT_PAGE)->render();
        $this->link->setPageNumber($this->positions->getLastPage());
        $pages[] = $last->reset()->setData($this->link, static::NEXT_PAGE . static::NEXT_PAGE)->render();

        $this->pager->setData(
            implode('', $pages),
            $showPositions ? $this->positions : null
        );
        return $this->pager->render();
    }

    public function getPager(): IPager
    {
        return $this->positions->getPager();
    }
}

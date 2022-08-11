<?php

namespace kalanis\kw_pager\Interfaces;

/**
 * Interface IRenderEngine
 * How to display result
 * @package kalanis\kw_pager\Interfaces
 */
interface IRenderEngine
{
    /**
     * If rendering area has this option - how many page inputs will show themselves
     * @param int $number
     * @return IRenderEngine
     */
    public function setDisplayInputsCount(int $number): self;

    /**
     * Set used pager
     * @param IPager|null $pager
     * @return IRenderEngine
     */
    public function setPager(?IPager $pager): self;

    /**
     * Get pager known to object
     * @return IPager|null
     */
    public function getPager(): ?IPager;

    /**
     * Render content to output (cli or html)
     * @return string
     */
    public function render(): string;
}
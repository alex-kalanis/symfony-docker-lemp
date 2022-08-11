<?php

namespace kalanis\kw_address_handler\examples;


use kalanis\kw_address_handler\Handler;
use kalanis\kw_address_handler\SingleVariable;


/**
 * Class PageLink
 * @package kalanis\kw_address_handler\examples
 * Update links with data from pager.
 *
 * Example:

$inputs = new kalanis\kw_input\Interfaces\Inputs();

...

$urlLink = new PageLink(new Handler($inputs), 7, 'paging');
echo $urlLink->getPageLink(); // got page 7

...

$urlLink->setPageNumber(3);
echo $urlLink->getPageLink(); // got page 3

 */
class PageLink
{
    const DEFAULT_VAR_NAME = 'page';

    /** @var Handler */
    protected $urlHandler;
    /** @var SingleVariable */
    protected $urlVariable;
    /** @var int */
    protected $page = 1;
    /** @var string */
    protected $varName = self::DEFAULT_VAR_NAME;

    public function __construct(Handler $urlHandler, int $page = 1, string $variableName = self::DEFAULT_VAR_NAME)
    {
        $this->urlHandler = $urlHandler;
        $this->urlVariable = new SingleVariable($urlHandler->getParams());
        $this->urlVariable->setVariableName($variableName);
        $this->urlVariable->setVariableValue(1);
        $this->page = $page;
    }

    public function setPageNumber(int $page): void
    {
        $this->page = $page;
    }

    public function getPageLink(): string
    {
        $this->urlVariable->setVariableValue((string) $this->page);
        return strval($this->urlHandler->getAddress());
    }
}

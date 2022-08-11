<?php

namespace kalanis\kw_connect\core;


use kalanis\kw_connect\core\Interfaces\IFilterFactory;
use kalanis\kw_connect\core\Interfaces\IFilterSubs;


/**
 * Trait TMultiple
 * @package kalanis\kw_connect\core
 * Multiple filters behaves as one for that column - shared things
 */
trait TMultiple
{
    /** @var IFilterFactory */
    protected $filterFactory = null;

    public function addFilterFactory(IFilterFactory $factory): void
    {
        $this->filterFactory = $factory;
    }

    /**
     * @param string $colName
     * @param array<string|mixed> $value
     * @throws ConnectException
     * @return $this
     * @codeCoverageIgnore because need data somewhere in storage
     */
    public function setFiltering(string $colName, $value)
    {
        foreach ($value as list($filterType, $expected)) {
            $subFilter = $this->filterFactory->getFilter($filterType);
            if ($subFilter instanceof IFilterSubs) {
                $subFilter->addFilterFactory($this->filterFactory);
            }
            $subFilter->setDataSource($this->{$this->getDataSourceName()});
            $subFilter->setFiltering($colName, $expected);
        }
        return $this;
    }

    protected function getDataSourceName(): string
    {
        return 'dataSource';
    }
}

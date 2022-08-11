<?php

namespace kalanis\kw_connect\arrays\Filters;


use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IFilterSubs;
use kalanis\kw_connect\core\TMultiple;


/**
 * Class Multiple
 * @package kalanis\kw_connect\core\Filters\Arrays
 * Multiple filters behaves as one for that column
 */
class Multiple extends AType implements IFilterSubs
{
    use TMultiple;

    /**
     * @param string $colName
     * @param array<string|mixed> $value
     * @throws ConnectException
     * @return $this|mixed
     * must be different - pass data there and back
     */
    public function setFiltering(string $colName, $value)
    {
        $sourceName = $this->getDataSourceName();
        $data = $this->$sourceName;
        foreach ($value as list($filterType, $expected)) {
            $subFilter = $this->filterFactory->getFilter($filterType);
            if ($subFilter instanceof IFilterSubs) {
                $subFilter->addFilterFactory($this->filterFactory);
            }
            $subFilter->setDataSource($data);
            $subFilter->setFiltering($colName, $expected);
            $data = $subFilter->getDataSource();
        }
        $this->$sourceName = $data;
        return $this;
    }
}

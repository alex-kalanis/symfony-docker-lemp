<?php

namespace kalanis\kw_connect\doctrine_dbal;


use Doctrine\DBAL\Query\QueryBuilder;
use kalanis\kw_connect\arrays\Row;
use kalanis\kw_connect\core\AConnector;
use kalanis\kw_connect\core\Interfaces\IFilterFactory;
use kalanis\kw_connect\core\Interfaces\IFilterSubs;
use kalanis\kw_connect\core\Interfaces\IIterableConnector;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_connect\core\Interfaces\IRow;


/**
 * Class Connector
 * @package kalanis\kw_connect\doctrine_dbal
 * Data source is Doctrine DBAL
 */
class Connector extends AConnector implements IIterableConnector
{
    /** @var QueryBuilder */
    protected $queryBuilder;
    /** @var string */
    protected $primaryKey;
    /** @var array<int, array<string>> */
    protected $ordering;
    /** @var int|null */
    protected $limit;
    /** @var int|null */
    protected $offset;
    /** @var bool */
    protected $dataFetched = false;

    public function __construct(QueryBuilder $queryBuilder, string $primaryKey)
    {
        $this->queryBuilder = $queryBuilder;
        $this->primaryKey = $primaryKey;
    }

    public function setFiltering(string $colName, string $filterType, $value): void
    {
        $type = $this->getFilterFactory()->getFilter($filterType);
        if ($type instanceof IFilterSubs) {
            $type->addFilterFactory($this->getFilterFactory());
        }
        $type->setDataSource($this->queryBuilder);
        $type->setFiltering($colName, $value);
    }

    public function setOrdering(string $colName, string $direction): void
    {
        $this->ordering[] = [$colName, $direction];
    }

    public function setPagination(?int $offset, ?int $limit): void
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getTotalCount(): int
    {
        $this->queryBuilder->select('count(' . $this->primaryKey. ')');
        return intval($this->queryBuilder->fetchOne());
    }

    public function fetchData(): void
    {
        foreach ($this->ordering as list($colName, $direction)) {
            $dir = IOrder::ORDER_ASC == $direction ? 'ASC' : 'DESC' ;
            $this->queryBuilder->orderBy(strval($colName), strval($dir));
        }
        if (!is_null($this->offset)) {
            $this->queryBuilder->setFirstResult($this->offset);
        }
        if (!is_null($this->limit)) {
            $this->queryBuilder->setMaxResults($this->limit);
        }
        $this->parseData();
    }

    protected function parseData(): void
    {
        foreach (
            $this->queryBuilder->getConnection()->iterateNumeric(
                $this->queryBuilder->getSQL(),
                $this->queryBuilder->getParameters(),
                $this->queryBuilder->getParameterTypes()
            ) as $value
        ) {
            $this->translatedData[$this->getPrimaryKey($value)] = $this->getTranslated($value);
        }
    }

    /**
     * @param array<int|string, bool|float|int|string|null> $data
     * @return IRow
     */
    protected function getTranslated($data): IRow
    {
        return new Row($data);
    }

    /**
     * @param array<mixed> $data
     * @return string
     */
    protected function getPrimaryKey($data): string
    {
        return strval($data[$this->primaryKey]);
    }

    public function getFilterFactory(): IFilterFactory
    {
        return Filters\Factory::getInstance();
    }
}

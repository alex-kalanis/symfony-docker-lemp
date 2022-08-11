<?php

namespace kalanis\kw_mapper\Search;


use kalanis\kw_mapper\Interfaces\IQueryBuilder;
use kalanis\kw_mapper\MapperException;


/**
 * Class Search
 * @package kalanis\kw_mapper\Search
 * Complex searching
 */
class Search extends ASearch
{
    /**
     * Property is not exact to the value
     * @param string $property
     * @param string $value
     * @throws MapperException
     * @return $this
     */
    public function notExact(string $property, $value)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->notExact($table, $column, $value);
        return $this;
    }

    /**
     * Property is exact to the value
     * @param string $property
     * @param string $value
     * @throws MapperException
     * @return $this
     */
    public function exact(string $property, $value)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->exact($table, $column, $value);
        return $this;
    }

    /**
     * @param string $property
     * @param string $value
     * @param bool $equals
     * @throws MapperException
     * @return $this
     */
    public function from(string $property, $value, bool $equals = true)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->from($table, $column, $value, $equals);
        return $this;
    }

    /**
     * @param string $property
     * @param string $value
     * @param bool $equals
     * @throws MapperException
     * @return $this
     */
    public function to(string $property, $value, bool $equals = true)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->to($table, $column, $value, $equals);
        return $this;
    }

    /**
     * Property is like value
     * @param string $property
     * @param string $value
     * @throws MapperException
     * @return $this
     */
    public function like(string $property, $value)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->like($table, $column, $value);
        return $this;
    }

    /**
     * Property is not like value
     * @param string $property
     * @param string $value
     * @throws MapperException
     * @return $this
     */
    public function notLike(string $property, $value)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->notLike($table, $column, $value);
        return $this;
    }

    /**
     * Property match regexp pattern - DATABASE DEPENDENT
     * @param string $property
     * @param string $pattern
     * @throws MapperException
     * @return $this
     */
    public function regexp(string $property, string $pattern)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->regexp($table, $column, $pattern);
        return $this;
    }

    /**
     * Property is between values
     * @param string $property
     * @param string $min
     * @param string $max
     * @throws MapperException
     * @return $this
     */
    public function between(string $property, $min, $max)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->between($table, $column, $min, $max);
        return $this;
    }

    /**
     * Property is null
     * @param string $property
     * @throws MapperException
     * @return $this
     */
    public function null(string $property)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->null($table, $column);
        return $this;
    }

    /**
     * Property is not null
     * @param string $property
     * @throws MapperException
     * @return $this
     */
    public function notNull(string $property)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->notNull($table, $column);
        return $this;
    }

    /**
     * Property is in values
     * @param string $property
     * @param array<string|int|float> $values
     * @throws MapperException
     * @return $this
     */
    public function in(string $property, array $values)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->in($table, $column, $values);
        return $this;
    }

    /**
     * Property is not in values
     * @param string $property
     * @param array<string|int|float> $values
     * @throws MapperException
     * @return $this
     */
    public function notIn(string $property, array $values)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->notIn($table, $column, $values);
        return $this;
    }

    /**
     * Need fulfill all conditions
     * @return $this
     */
    public function useAnd()
    {
        $this->connector->useAnd();
        return $this;
    }

    /**
     * Need fulfill only one condition
     * @return $this
     */
    public function useOr()
    {
        $this->connector->useOr();
        return $this;
    }

    /**
     * Paging limit
     * @param int|null $limit
     * @return $this
     */
    public function limit(?int $limit)
    {
        $this->connector->limit($limit);
        return $this;
    }

    /**
     * Paging offset
     * @param int|null $offset
     * @return $this
     */
    public function offset(?int $offset)
    {
        $this->connector->offset($offset);
        return $this;
    }

    /**
     * Add ordering by property
     * @param string $property
     * @param string $direction
     * @throws MapperException
     * @return $this
     */
    public function orderBy(string $property, string $direction = IQueryBuilder::ORDER_ASC)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->orderBy($table, $column, $direction);
        return $this;
    }

    /**
     * Add grouping by property
     * @param string $property
     * @throws MapperException
     * @return $this
     */
    public function groupBy(string $property)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->groupBy($table, $column);
        return $this;
    }

    /**
     * Add child which will be mounted to the results
     * @param string $childAlias
     * @param string $joinType
     * @param string $parentAlias
     * @param string $customAlias
     * @throws MapperException
     * @return $this
     */
    public function child(string $childAlias, string $joinType = IQueryBuilder::JOIN_LEFT, string $parentAlias = '', string $customAlias = '')
    {
        $this->connector->child($childAlias, $joinType, $parentAlias, $customAlias);
        return $this;
    }

    /**
     * That child is not set for chosen parent
     * @param string $childAlias
     * @param string $property
     * @throws MapperException
     * @return $this
     */
    public function childNotExist(string $childAlias, string $property)
    {
        list($table, $column) = $this->parseProperty($property);
        $this->connector->childNotExist($childAlias, $table, $column);
        return $this;
    }
}

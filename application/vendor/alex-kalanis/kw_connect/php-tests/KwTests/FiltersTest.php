<?php

namespace KwTests;


use kalanis\kw_connect\search;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_mapper\MapperException;


/**
 * Class FiltersTest
 * @package KwTests
 * @requires extension PDO
 * @requires extension pdo_sqlite
 */
class FiltersTest extends AKwTests
{
    /**
     * @throws ConnectException
     */
    public function testFailSource()
    {
        $filter = new search\Filters\Exact();
        $this->expectException(ConnectException::class);
        $filter->setDataSource(null);
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testExact()
    {
        $this->dataRefill();
        $filter = new search\Filters\Exact();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('flight', 1);
        $this->assertEquals(4, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testContains()
    {
        $this->dataRefill();
        $filter = new search\Filters\Contains();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('name', '%h%');
        $this->assertEquals(4, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testFrom()
    {
        $this->dataRefill();
        $filter = new search\Filters\From();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('counter', 456);
        $this->assertEquals(2, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testFromWith()
    {
        $filter = new search\Filters\FromWith();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('counter', 456);
        $this->assertEquals(3, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testTo()
    {
        $filter = new search\Filters\To();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('counter', 456);
        $this->assertEquals(6, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testToWith()
    {
        $filter = new search\Filters\ToWith();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('counter', 456);
        $this->assertEquals(7, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testRangeOk()
    {
        $filter = new search\Filters\Range();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $filter->setFiltering('counter', [345, 678]);
        $this->assertEquals(2, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testRangeFail()
    {
        $filter = new search\Filters\Range();
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $this->expectException(ConnectException::class);
        $filter->setFiltering('counter', 456);
        $this->expectException(ConnectException::class);
        $filter->setFiltering('counter', null);
        $this->expectException(ConnectException::class);
        $filter->setFiltering('counter', 'ijn');
        $this->expectException(ConnectException::class);
        $filter->setFiltering('counter', [456]);
        $this->expectException(ConnectException::class);
        $filter->setFiltering('counter', [1=>789]);
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testMultiple1()
    {
        $filter = new search\Filters\Multiple();
        $filter->addFilterFactory(search\Filters\Factory::getInstance());
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));

        $filter->setFiltering('name', [
            // filter type => expected value; everything over column defined previously
            [search\Filters\Factory::ACTION_CONTAINS, '%e%'],
            [search\Filters\Factory::ACTION_CONTAINS, '%a%'],
        ]);
        $this->assertEquals(3, $filter->getDataSource()->getCount());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testMultiple2()
    {
        $filter = new search\Filters\Multiple();
        $filter->addFilterFactory(search\Filters\Factory::getInstance());
        $filter->setDataSource(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));

        $filter->setFiltering('name', [
            // filter type => expected value; everything over column defined previously
            [
                search\Filters\Factory::ACTION_MULTIPLE, [
                    [search\Filters\Factory::ACTION_CONTAINS, '%a%'],
                ]
            ],
            [search\Filters\Factory::ACTION_CONTAINS, '%e%'],
        ]);
        $this->assertEquals(3, $filter->getDataSource()->getCount());
    }
}

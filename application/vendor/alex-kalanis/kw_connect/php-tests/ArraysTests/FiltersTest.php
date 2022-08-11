<?php

namespace ArraysTests;


use CommonTestClass;
use kalanis\kw_connect\arrays;
use kalanis\kw_connect\core\AConnector;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IRow;


class FiltersTest extends CommonTestClass
{
    /**
     * @throws ConnectException
     */
    public function testFailSource()
    {
        $filter = new arrays\Filters\Exact();
        $this->expectException(ConnectException::class);
        $filter->setDataSource(null);
    }

    /**
     * @throws ConnectException
     */
    public function testExact()
    {
        $filter = new arrays\Filters\Exact();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('mno', true);
        $this->assertEquals(4, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testContains()
    {
        $filter = new arrays\Filters\Contains();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('def', 'a');
        $this->assertEquals(4, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testFrom()
    {
        $filter = new arrays\Filters\From();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('jkl', 456);
        $this->assertEquals(2, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testFromWith()
    {
        $filter = new arrays\Filters\FromWith();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('jkl', 456);
        $this->assertEquals(3, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testTo()
    {
        $filter = new arrays\Filters\To();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('jkl', 456);
        $this->assertEquals(6, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testToWith()
    {
        $filter = new arrays\Filters\ToWith();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('jkl', 456);
        $this->assertEquals(7, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testRangeOk()
    {
        $filter = new arrays\Filters\Range();
        $filter->setDataSource($this->getDataSource());
        $filter->setFiltering('jkl', [345, 678]);
        $this->assertEquals(2, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testRangeFail()
    {
        $filter = new arrays\Filters\Range();
        $filter->setDataSource($this->getDataSource());
        $this->expectException(ConnectException::class);
        $filter->setFiltering('jkl', 456);
        $this->expectException(ConnectException::class);
        $filter->setFiltering('jkl', null);
        $this->expectException(ConnectException::class);
        $filter->setFiltering('jkl', 'ijn');
        $this->expectException(ConnectException::class);
        $filter->setFiltering('jkl', [456]);
        $this->expectException(ConnectException::class);
        $filter->setFiltering('jkl', [1=>789]);
    }

    /**
     * @throws ConnectException
     */
    public function testMultiple1()
    {
        $filter = new arrays\Filters\Multiple();
        $filter->addFilterFactory(arrays\Filters\Factory::getInstance());
        $filter->setDataSource($this->getDataSource());

        $filter->setFiltering('def', [
            // filter type => expected value; everything over column defined previously
            [arrays\Filters\Factory::ACTION_CONTAINS, 'e'],
            [arrays\Filters\Factory::ACTION_CONTAINS, 'a'],
        ]);
        $this->assertEquals(3, count($filter->getDataSource()));
    }

    /**
     * @throws ConnectException
     */
    public function testMultiple2()
    {
        $filter = new arrays\Filters\Multiple();
        $filter->addFilterFactory(arrays\Filters\Factory::getInstance());
        $filter->setDataSource($this->getDataSource());

        $filter->setFiltering('def', [
            // filter type => expected value; everything over column defined previously
            [
                arrays\Filters\Factory::ACTION_MULTIPLE, [
                    [arrays\Filters\Factory::ACTION_CONTAINS, 'a'],
                ]
            ],
            [arrays\Filters\Factory::ACTION_CONTAINS, 'e'],
        ]);
        $this->assertEquals(3, count($filter->getDataSource()));
    }

    protected function getDataSource(): arrays\FilteringArrays
    {
        $connect = new Connect($this->sourceRows());
        $connect->fetchData();
        return new arrays\FilteringArrays($connect->getTranslatedData());
    }
}


class Connect extends AConnector
{
    /** @var array */
    protected $dataSource = [];

    public function __construct(array $source)
    {
        $this->dataSource = $source;
    }

    protected function getFiltered(&$data)
    {
        return new arrays\FilteringArrays($data);
    }

    public function getTranslated($data): IRow
    {
        return new arrays\Row($data);
    }

    public function fetchData(): void
    {
        $this->parseData();
    }

    protected function parseData(): void
    {
        $this->translatedData = array_map([$this, 'getTranslated'], $this->dataSource);
    }

    public function &getTranslatedData(): array
    {
        return $this->translatedData;
    }
}

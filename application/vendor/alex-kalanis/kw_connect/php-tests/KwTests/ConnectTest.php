<?php

namespace KwTests;


use kalanis\kw_connect\arrays;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_connect\records;
use kalanis\kw_connect\search;
use kalanis\kw_mapper\MapperException;


/**
 * Class ConnectTest
 * @package KwTests
 * @requires extension PDO
 * @requires extension pdo_sqlite
 */
class ConnectTest extends AKwTests
{
    /**
     * @throws ConnectException
     */
    public function testConnectorRecords()
    {
        $lib = new records\Connector($this->rows());
        $lib->setFiltering('target', '', 'any'); // filter type not need for this one
        $lib->setOrdering('name', IOrder::ORDER_DESC);
        $lib->setPagination(2, 2);
        $this->assertEquals(3, $lib->getTotalCount());
        $lib->setOrdering('counter', IOrder::ORDER_ASC);
        $lib->fetchData();
        $this->assertNotEmpty($lib->getFilterFactory());
    }

    /**
     * @throws ConnectException
     * @throws MapperException
     */
    public function testConnectorSearch()
    {
        $lib = new search\Connector(new \kalanis\kw_mapper\Search\Search(new XTestRecord()));
        $lib->setFiltering('target', arrays\Filters\Factory::ACTION_MULTIPLE, [ // value
            [ // row with another filter -> filter type, value to compare
                arrays\Filters\Factory::ACTION_MULTIPLE, [ // another multiple with its inner filters as array in value
                    [arrays\Filters\Factory::ACTION_EXACT, 'any'], // inner filters in multiple filter -> filter type, value to compare
                ]
            ],
        ]);
        $this->assertEquals(6, $lib->getTotalCount());
        $lib->setOrdering('name', IOrder::ORDER_ASC);
        $lib->setPagination(1, 4);
        $lib->fetchData();
        $this->assertEquals(4, count(iterator_to_array($lib)));
    }

    /**
     * @throws ConnectException
     */
    public function testConnectorRec2()
    {
        $lib = new records\Connector([]); // empty source
        $this->assertEquals(0, $lib->getTotalCount());
    }

    /**
     * @throws ConnectException
     */
    public function testConnectorData1()
    {
        $lib = new records\Connector($this->rows());
        $lib->setOrdering('id', IOrder::ORDER_ASC);
        $lib->fetchData();
        $this->assertEquals(5, $lib->getTotalCount());
        $content = iterator_to_array($lib);
        $this->assertEquals('emil', $content[0]->getValue('name'));
        $this->assertEquals('josh', $content[1]->getValue('name'));
        $this->assertEquals('ewan', $content[2]->getValue('name'));
        $this->assertEquals('kami', $content[3]->getValue('name'));
    }

    /**
     * @throws ConnectException
     */
    public function testConnectorData2()
    {
        $lib = new records\Connector($this->rows());
        $lib->setOrdering('id', IOrder::ORDER_DESC);
        $lib->fetchData();
        $this->assertEquals(5, $lib->getTotalCount());
        $content = iterator_to_array($lib);
        $this->assertEquals('chuck', $content[0]->getValue('name'));
        $this->assertEquals('kami', $content[1]->getValue('name'));
        $this->assertEquals('ewan', $content[2]->getValue('name'));
        $this->assertEquals('josh', $content[3]->getValue('name'));
    }

    protected function rows(): array
    {
        return [
            $this->loadedRec(3),
            $this->loadedRec(4),
            $this->loadedRec(5),
            $this->loadedRec(6),
            $this->loadedRec(7),
        ];
    }
}

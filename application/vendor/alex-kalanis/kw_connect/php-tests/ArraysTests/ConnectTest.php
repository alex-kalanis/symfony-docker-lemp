<?php

namespace ArraysTests;


use CommonTestClass;
use kalanis\kw_connect\arrays;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\core\Interfaces\IOrder;


class ConnectTest extends CommonTestClass
{
    /**
     * @throws ConnectException
     */
    public function testConnector1()
    {
        $lib = new arrays\Connector($this->sourceRows()); // no PK
        $lib->setFiltering('pqr', arrays\Filters\Factory::ACTION_EXACT, true);
        $lib->setOrdering('jkl', IOrder::ORDER_DESC);
        $lib->setPagination(2, 2);
        $lib->fetchData();
        $this->assertEquals(4, $lib->getTotalCount());
    }

    /**
     * @throws ConnectException
     */
    public function testConnectorData1()
    {
        $lib = new arrays\Connector($this->sourceRows()); // no PK
        $lib->setOrdering('jkl', IOrder::ORDER_ASC);
        $lib->fetchData();
        $this->assertEquals(9, $lib->getTotalCount());
        $content = iterator_to_array($lib);
        $this->assertEquals('josh', $content[0]->getValue('def'));
        $this->assertEquals('ewan', $content[1]->getValue('def'));
        $this->assertEquals('dave', $content[2]->getValue('def'));
        $this->assertEquals('kami', $content[3]->getValue('def'));
    }

    /**
     * @throws ConnectException
     */
    public function testConnectorData2()
    {
        $lib = new arrays\Connector($this->sourceRows()); // no PK
        $lib->setOrdering('jkl', IOrder::ORDER_DESC);
        $lib->fetchData();
        $this->assertEquals(9, $lib->getTotalCount());
        $content = iterator_to_array($lib);
        $this->assertEquals('emil', $content[0]->getValue('def'));
        $this->assertEquals('wayne', $content[1]->getValue('def'));
        $this->assertEquals('john', $content[2]->getValue('def'));
        $this->assertEquals('chuck', $content[3]->getValue('def'));
    }

    /**
     * @throws ConnectException
     */
    public function testConnector2()
    {
        $lib = new arrays\Connector($this->sourceRows(), 'abc'); // with PK
        $lib->setFiltering('pqr', arrays\Filters\Factory::ACTION_MULTIPLE, [ // value
            [ // row with another filter -> filter type, value to compare
                arrays\Filters\Factory::ACTION_MULTIPLE, [ // another multiple with its inner filters as array in value
                    [arrays\Filters\Factory::ACTION_EXACT, false], // inner filters in multiple filter -> filter type, value to compare
                ]
            ],
        ]);
        $lib->setOrdering('jkl', IOrder::ORDER_ASC);
        $this->assertEquals(5, $lib->getTotalCount());
    }

    /**
     * @throws ConnectException
     */
    public function testConnector3()
    {
        $lib = new arrays\Connector([]); // empty source
        $this->assertEquals(0, $lib->getTotalCount());
    }
}

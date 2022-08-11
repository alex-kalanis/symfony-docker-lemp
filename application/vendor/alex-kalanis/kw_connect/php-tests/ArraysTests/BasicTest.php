<?php

namespace ArraysTests;


use CommonTestClass;
use kalanis\kw_connect\arrays;
use kalanis\kw_connect\core\ConnectException;


class BasicTest extends CommonTestClass
{
    /**
     * @param array $data
     * @param string|int $unknown
     * @param string|int $exists
     * @param mixed $expect
     * @param int $count
     * @dataProvider rowProvider
     * @throws ConnectException
     */
    public function testRow(array $data, $unknown, $exists, $expect, $count)
    {
        $data = new arrays\Row($data);
        $this->assertInstanceOf('\kalanis\kw_connect\core\Interfaces\IRow', $data);

        $this->assertFalse($data->__isset($unknown));
        $this->assertFalse(isset($data->$unknown));

        $this->assertTrue($data->__isset($exists));
        $this->assertTrue(isset($data->$exists));

        $this->assertEquals($expect, $data->getValue($exists));
    }

    /**
     * @param array $data
     * @param string|int $unknown
     * @param string|int $exists
     * @param mixed $expect
     * @param int $count
     * @dataProvider rowProvider
     */
    public function testFiltering(array $data, $unknown, $exists, $expect, $count)
    {
        $xData = [] + $data;
        $filter = new arrays\FilteringArrays($xData);
        $this->assertInstanceOf('\ArrayAccess', $filter);
        $this->assertInstanceOf('\Countable', $filter);
        $this->assertEquals($data, $filter->getArray());

        $this->assertFalse($filter->offsetExists($unknown));
        $this->assertFalse(isset($filter[$unknown]));
        $this->assertNull($filter->offsetGet($unknown));

        $this->assertTrue($filter->offsetExists($exists));
        $this->assertTrue(isset($filter[$exists]));
        $this->assertEquals($expect, $filter->offsetGet($exists));

        $this->assertEquals($count, $filter->count());
        $filter->offsetUnset($unknown);
        $filter->offsetUnset($exists);
        $this->assertEquals($count - 1, $filter->count());

        $filter->resetArray();
        $this->assertEmpty($filter->getArray());
        $filter->setArray($data);
        $this->assertEquals($count, $filter->count());

        $filter->offsetSet('dummy', 'wee');
    }

    public function rowProvider(): array
    {
        return [
            [['abc' => 'def', 'ghi' => 'jkl', 'mno' => 'pqr'], 'fff', 'ghi', 'jkl', 3],
            [['abc', 'def', 'ghi', 'jkl', 'mno', 'pqr'], 40, 3, 'jkl', 6],
            [[123, 456, 789, 012, 345, 678], 'hehe', 4, 345, 6],
        ];
    }
}

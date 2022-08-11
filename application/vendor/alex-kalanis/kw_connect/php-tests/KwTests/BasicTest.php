<?php

namespace KwTests;


use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_connect\records;
use kalanis\kw_connect\search;
use kalanis\kw_mapper\Records\ARecord;


/**
 * Class BasicTest
 * @package KwTests
 * @requires extension PDO
 * @requires extension pdo_sqlite
 */
class BasicTest extends AKwTests
{
    /**
     * @param ARecord $data
     * @param string|int $unknownKey
     * @param string|int $existsKey
     * @param mixed $expect
     * @param string $passFunc
     * @param bool $useFunc
     * @dataProvider rowProvider
     * @throws ConnectException
     */
    public function testRowRecord(ARecord $data, $unknownKey, $existsKey, $expect, $passFunc, $useFunc)
    {
        $data = new records\Row($data);
        $this->assertInstanceOf('\kalanis\kw_connect\core\Interfaces\IRow', $data);

        $this->assertFalse($data->__isset($unknownKey));
        $this->assertFalse(isset($data->$unknownKey));

        $this->assertTrue($data->__isset($existsKey));
        $this->assertTrue(isset($data->$existsKey));

        $this->assertEquals($expect, $data->getValue($existsKey));

        $this->assertFalse($data->__isset($passFunc));
        $this->assertFalse(isset($data->$passFunc));

        if ($useFunc) {
            $this->assertEquals($expect, $data->getValue($passFunc));
        }
    }

    /**
     * @param ARecord $data
     * @param string|int $unknownKey
     * @param string|int $existsKey
     * @param mixed $expect
     * @param string $passFunc
     * @param bool $useFunc
     * @dataProvider rowProvider
     * @throws ConnectException
     */
    public function testRowSearch(ARecord $data, $unknownKey, $existsKey, $expect, $passFunc, $useFunc)
    {
        $data = new search\Row($data);
        $this->assertInstanceOf('\kalanis\kw_connect\core\Interfaces\IRow', $data);

        $this->assertFalse($data->__isset($unknownKey));
        $this->assertFalse(isset($data->$unknownKey));

        $this->assertTrue($data->__isset($existsKey));
        $this->assertTrue(isset($data->$existsKey));

        $this->assertEquals($expect, $data->getValue($existsKey));

        $this->assertFalse($data->__isset($passFunc));
        $this->assertFalse(isset($data->$passFunc));

        if ($useFunc) {
            $this->assertEquals($expect, $data->getValue($passFunc));
        }
    }

    public function rowProvider(): array
    {
        return [
            [$this->loadedRec(1), 'fff', 'name', 'dave', 'getName', true],
            [$this->loadedRec(2), 40, 'target', 'one', 'getTarget', false],
            [$this->loadedRec(3), 'hehe', 'counter', 789, 'getCounter', false],
        ];
    }
}

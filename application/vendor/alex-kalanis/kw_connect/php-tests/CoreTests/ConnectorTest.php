<?php

namespace CoreTests;


use CommonTestClass;
use kalanis\kw_connect\arrays\Row;
use kalanis\kw_connect\core\AConnector;
use kalanis\kw_connect\core\Interfaces\IRow;


class ConnectorTest extends CommonTestClass
{
    public function testConnector()
    {
        $data = new Connect();
        $this->assertInstanceOf('\ArrayAccess', $data);
        $this->assertInstanceOf('\IteratorAggregate', $data);
        $this->assertInstanceOf('\Countable', $data);

        $this->assertEmpty($data->count());

        $data->offsetSet('different', 'another');
        $data->offsetSet('wub', 'wuz');
        $data->offsetSet('dira', ['fkl', 'uhb']);

        $this->assertEquals('another', $data->getByKey('different')->getValue('pk'));
        $this->assertEquals('wuz', $data->getByKey('wub')->getValue('pk'));
        $this->assertEquals('uhb', $data->getByKey('dira')->getValue(1));
        $this->assertNull($data->getByKey('unknown'));
    }
}


class Connect extends AConnector
{
    protected function parseData(): void
    {
        # translate items into IRow
        foreach ($this->translatedData as $key => &$input) {
            if (is_object($input) && ($input instanceof IRow)) {
                continue;
            }
            if (is_array($input)) {
                $this->translatedData[$key] = new Row($input);
            } else {
                $this->translatedData[$key] = new Row(['pk' => $input]);
            }
        }
    }

    public function getByKey($key): ?IRow
    {
        $this->parseData();
        return parent::getByKey($key);
    }
}

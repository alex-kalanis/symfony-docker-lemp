<?php

namespace KwTests;


use CommonTestClass;
use kalanis\kw_mapper\Interfaces\IDriverSources;
use kalanis\kw_mapper\Interfaces\IEntryType;
use kalanis\kw_mapper\MapperException;
use kalanis\kw_mapper\Mappers\Database\ADatabase;
use kalanis\kw_mapper\Records\ARecord;
use kalanis\kw_mapper\Records\ASimpleRecord;
use kalanis\kw_mapper\Storage\Database\Config;
use kalanis\kw_mapper\Storage\Database\ConfigStorage;
use kalanis\kw_mapper\Storage\Database\DatabaseSingleton;
use kalanis\kw_mapper\Storage\Database\PDO\SQLite;
use PDO;


abstract class AKwTests extends CommonTestClass
{
    /** @var null|SQLite */
    protected $database = null;
    protected $filled = false;

    protected function loadedRec($id): ARecord
    {
        $this->dataRefill();
        $rec = new XTestRecord();
        $rec->id = $id;
        $rec->load();
        return $rec;
    }

    /**
     * @param bool $force
     * @throws MapperException
     */
    protected function dataRefill($force = false): void
    {
        if (!$this->filled || $force) {
            $conf = Config::init()->setTarget(
                IDriverSources::TYPE_PDO_SQLITE,
                'test_sqlite_local',
                ':memory:',
                0,
                null,
                null,
                ''
            );
            $conf->setParams(12000, true);
            ConfigStorage::getInstance()->addConfig($conf);
            $this->database = DatabaseSingleton::getInstance()->getDatabase($conf);
            $this->database->addAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->database->reconnect();
            $this->assertTrue($this->database->exec($this->dropTable(), []));
            $this->assertTrue($this->database->exec($this->basicTable(), []));
            $this->assertTrue($this->database->exec($this->fillTable(), []));
            $this->assertEquals(9, $this->database->rowCount());
            $this->filled = true;
        }
    }

    protected function dropTable(): string
    {
        return 'DROP TABLE IF EXISTS "x_testing_rows"';
    }

    protected function basicTable(): string
    {
        return 'CREATE TABLE IF NOT EXISTS "x_testing_rows" (
  "xtr_id" INT AUTO_INCREMENT NOT NULL PRIMARY KEY ,
  "xtr_name" VARCHAR(20) NULL,
  "xtr_target" VARCHAR(20) NULL,
  "xtr_counter" INT(10) NULL,
  "xtr_flight" INT(1) NULL,
  "xtr_enabled" INT(1) NULL
)';
    }

    protected function fillTable(): string
    {
        return 'INSERT INTO "x_testing_rows" ("xtr_id", "xtr_name", "xtr_target", "xtr_counter", "xtr_flight", "xtr_enabled") VALUES
(1, "dave", "any", 123, 0, 1),
(2, "john", "one", 456, 0, 0),
(3, "emil", "any", 789, 1, 1),
(4, "josh", "any", 101, 1, 0),
(5, "ewan", "one", 112, 0, 0),
(6, "kami", "any", 131, 1, 0),
(7, "chuck", "one", 415, 0, 1),
(8, "phil", "any", 161, 1, 1),
(9, "wayne", "any", 718, 0, 0)
';
    }
}


/**
 * Class XTestRecord
 * @property int id
 * @property string name
 * @property string target
 * @property int counter
 * @property int flight
 * @property int enabled
 */
class XTestRecord extends ASimpleRecord
{
    protected function addEntries(): void
    {
        $this->addEntry('id', IEntryType::TYPE_INTEGER, 64);
        $this->addEntry('name', IEntryType::TYPE_STRING, 10);
        $this->addEntry('target', IEntryType::TYPE_SET, ['one', 'any']);
        $this->addEntry('counter', IEntryType::TYPE_INTEGER, 9999);
        $this->addEntry('flight', IEntryType::TYPE_INTEGER, 2);
        $this->addEntry('enabled', IEntryType::TYPE_INTEGER, 2);
        $this->setMapper('\KwTests\XTestMapper');
    }

    public function getName(): string
    {
        return (string) $this->offsetGet('name');
    }
}


class XTestMapper extends ADatabase
{
    protected function setMap(): void
    {
        $this->setSource('test_sqlite_local');
        $this->setTable('x_testing_rows');
        $this->setRelation('id', 'xtr_id');
        $this->setRelation('name', 'xtr_name');
        $this->setRelation('target', 'xtr_target');
        $this->setRelation('counter', 'xtr_counter');
        $this->setRelation('flight', 'xtr_flight');
        $this->setRelation('enabled', 'xtr_enabled');
        $this->addPrimaryKey('id');
    }
}

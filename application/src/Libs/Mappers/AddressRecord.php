<?php
namespace App\Libs\Mappers;


use kalanis\kw_mapper\Interfaces\IEntryType;
use kalanis\kw_mapper\Records;
use kalanis\kw_mapper\Storage;


/**
 * Class AddressRecord
 * Address record as data object as is in database
 * @property int $id
 * @property string $firstName
 * @property string $lastName
 * @property string $phone
 * @property string $email
 * @property string $note
 * @property string $deleted
 */
class AddressRecord extends Records\ASimpleRecord
{
    protected function addEntries(): void
    {
        $this->addEntry('id', IEntryType::TYPE_INTEGER, 2048);
        $this->addEntry('firstName', IEntryType::TYPE_STRING, 1024);
        $this->addEntry('lastName', IEntryType::TYPE_STRING, 1024);
        $this->addEntry('phone', IEntryType::TYPE_STRING, 50);
        $this->addEntry('email', IEntryType::TYPE_STRING, 1024);
        $this->addEntry('note', IEntryType::TYPE_STRING, 65536);
        $this->addEntry('deleted', IEntryType::TYPE_STRING, 32);
        $this->setMapper('\App\Libs\Mappers\AddressMapper');
    }
}

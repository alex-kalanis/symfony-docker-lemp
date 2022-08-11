<?php

namespace App\Libs\Mappers;


use kalanis\kw_mapper\Mappers;
use kalanis\kw_mapper\Storage;


/**
 * Class AddressMapper
 * @package App\Libs\Mappers
 * Map record entries on database columns
 */
class AddressMapper extends Mappers\Database\ADatabase
{
    protected function setMap(): void
    {
        $this->setSource('docker');
        $this->setTable('adresses');
        $this->setRelation('id', 'ad_id');
        $this->setRelation('firstName', 'ad_first_name');
        $this->setRelation('lastName', 'ad_last_name');
        $this->setRelation('phone', 'ad_phone');
        $this->setRelation('email', 'ad_email');
        $this->setRelation('note', 'ad_note');
        $this->setRelation('deleted', 'ad_deleted');
        $this->addPrimaryKey('id');
    }
}

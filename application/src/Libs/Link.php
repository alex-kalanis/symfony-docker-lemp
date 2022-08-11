<?php

namespace App\Libs;


use App\Libs\Mappers\AddressRecord;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_mapper\MapperException;
use kalanis\kw_mapper\Search\Search;


/**
 * Class Link
 * Translate record into link and back
 * @package App\Tasks\Database
 */
class Link
{
    public function getAsLink(string $firstName, string $lastName): string
    {
        return sprintf('%s-%s', urlencode($lastName), urlencode($firstName));
    }

    /**
     * @param string $link
     * @throws MapperException
     * @return AddressRecord|null
     */
    public function getAsRecord(string $link): ?AddressRecord
    {
        list($last, $first) = explode('-', $link, 2);
        $search = new Search(new AddressRecord());
        $search->exact('lastName', $last);
        $search->exact('firstName', $first);
        $search->orderBy('id', IOrder::ORDER_ASC);
        $objects = $search->getResults();
        if (!empty($objects)) {
            $object = reset($objects);
            return $object;
        } else {
            return null;
        }
    }
}

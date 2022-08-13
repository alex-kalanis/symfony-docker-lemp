<?php

namespace App\Tasks;


use App\Libs\Mappers\AddressRecord;
use App\Libs\Tables\AddressTable;
use kalanis\kw_clipr\Tasks\ATask;
use kalanis\kw_connect\core\Interfaces\IOrder;
use kalanis\kw_mapper\Search\Search;


/**
 * Class Listing
 * @package App\Tasks
 * @property string|null $order
 * @property string|null $direction
 */
class Listing extends ATask
{
    public function startup(): void
    {
        parent::startup();
        $this->params->addParam('order', 'order', null, null, null, 'Order by');
        $this->params->addParam('direction', 'direction', null, null, null, 'Direction');
    }

    public function desc(): string
    {
        return 'Listing addresses from Cli';
    }

    public function process(): void
    {
        $search = new Search(new AddressRecord());
        $search->null('deleted');
        $table = new AddressTable($this->inputs);
        $table->composeCli($search);
        $this->tableOrdering($table);
        $this->writeLn($table);
    }

    protected function tableOrdering(AddressTable $table): void
    {
        $availableKeys = $this->parseKeys();
        if (!is_null($this->order) && in_array($this->order, $availableKeys)) {
            $direction = IOrder::ORDER_ASC;
            if (!is_null($this->direction) && in_array(strtoupper($this->direction), [IOrder::ORDER_ASC, IOrder::ORDER_DESC])) {
                $direction = strtoupper($this->direction);
            }
            $table->getTable()->getOrder()->addPrependOrdering($this->order, $direction);
        }
    }

    protected function parseKeys(): array
    {
        $rec = new AddressRecord();
        $result = [];
        foreach ($rec as $key => $item) {
            $result[] = $key;
        }
        return $result;
    }
}

<?php

namespace App\Libs\Forms;


use App\Libs\Mappers\AddressRecord;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Form;
use kalanis\kw_rules\Interfaces\IRules;


/**
 * Class AddressForm
 * @package App\Libs\Mappers
 * Create form with mapping onto Address Record
 * @property Controls\Text $firstName
 * @property Controls\Text $lastName
 * @property Controls\Text $phone
 * @property Controls\Text $email
 * @property Controls\Textarea $note
 * @property Controls\Submit $submit
 */
class AddressForm extends Form
{
    public function composeFull(?AddressRecord $record): void
    {
        // first name input
        $frName = $this->addText('firstName', 'First name', $record ? $record->firstName : null);
        $frName->addRule(IRules::IS_NOT_EMPTY, 'Must be filled!');

        // last name input
        $srName = $this->addText('lastName', 'Last name', $record ? $record->lastName : null);
        $srName->addRule(IRules::IS_NOT_EMPTY, 'Must be filled!');

        $this->composeEdit($record);
    }

    public function composeEdit(?AddressRecord $record): void
    {
        // phone input
        $this->addText('phone', 'Phone', $record ? $record->phone : null);

        // email input
        $email = $this->addText('email', 'Email', $record ? $record->email : null);
        $email->addRule(IRules::IS_NOT_EMPTY, 'Must be filled!');
        $email->addRule(IRules::IS_EMAIL, 'Must be an email!');

        // note input
        $this->addTextarea('note', 'Note', $record ? $record->note : null);

        // submit
        $sub = $this->addSubmit('submit', 'Save');
        $sub->addRule(IRules::SATISFIES_CALLBACK, 'Must be unique!', [$this, 'uniqueData']);
    }

    /**
     * @param mixed $value
     * @return bool
     * @throws \kalanis\kw_mapper\MapperException
     */
    public function uniqueData($value): bool
    {
        if (!$fName = $this->getControl('firstName')) {
            return true;
        }
        if (!$sName = $this->getControl('lastName')) {
            return true;
        }
        $addr = new AddressRecord();
        $addr->firstName = strval($fName->getValue());
        $addr->lastName = strval($sName->getValue());
        return 0 >= $addr->count();
    }
}

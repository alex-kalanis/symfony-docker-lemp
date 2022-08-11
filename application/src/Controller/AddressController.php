<?php

namespace App\Controller;


use App\Libs;
use kalanis\kw_address_handler\Forward;
use kalanis\kw_address_handler\Sources;
use kalanis\kw_forms\Adapters\InputVarsAdapter;
use kalanis\kw_input\Inputs;
use kalanis\kw_input\Variables;
use kalanis\kw_mapper\Adapters\DataExchange;
use kalanis\kw_mapper\Search\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddressController extends AbstractController
{
    /**
     * @throws \kalanis\kw_forms\Exceptions\FormsException
     * @throws \kalanis\kw_mapper\MapperException
     * @throws \kalanis\kw_table\core\TableException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listing()
    {
        $search = new Search(new Libs\Mappers\AddressRecord());
        $search->null('deleted');
        $table = new Libs\Tables\AddressTable($this->inputVariables());
        $table->composeWeb($search);
        return $this->render('addresses/listing.html.twig', [
            'controller_name' => 'AddressController',
            'table' => $table,
        ]);
    }

    /**
     * @throws \kalanis\kw_forms\Exceptions\FormsException
     * @throws \kalanis\kw_mapper\MapperException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add()
    {
        $form = new Libs\Forms\AddressForm('address');
        $form->composeFull(null);
        $form->setInputs(new InputVarsAdapter($this->inputVariables()));
        if ($form->process()) {
            $who = new Libs\Mappers\AddressRecord();
            $ex = new DataExchange($who);
            $ex->import($form->getValues());

            // todo: discus - redirect back or to edit?
            if ($who->save()) {
                return $this->fw();
            }
        }

        return $this->render('addresses/add.html.twig', [
            'controller_name' => 'AddressController',
            'page_title' => 'Add contact',
            'form' => $form,
        ]);
    }

    /**
     * @param string $slug
     * @throws \kalanis\kw_forms\Exceptions\FormsException
     * @throws \kalanis\kw_mapper\MapperException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(string $slug)
    {
        $linked = new Libs\Link();
        $who = $linked->getAsRecord($slug);
        if (empty($who)) {
            return $this->fw();
        }

        $form = new Libs\Forms\AddressForm('address');
        $form->composeEdit($who);
        $form->setInputs(new InputVarsAdapter($this->inputVariables()));
        if ($form->process()) {
            $ex = new DataExchange($who);
            $ex->import($form->getValues());

            // todo: discus - redirect back or stay here?
            if ($who->save()) {
                return $this->fw();
            }
        }

        return $this->render('addresses/edit.html.twig', [
            'controller_name' => 'AddressController',
            'page_title' => 'Edit contact ' . $who->firstName . ' ' . $who->lastName,
            'firstName' => $who->firstName,
            'lastName' => $who->lastName,
            'form' => $form,
        ]);
    }

    /**
     * @param string $slug
     * @throws \kalanis\kw_forms\Exceptions\FormsException
     * @throws \kalanis\kw_mapper\MapperException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function note(string $slug)
    {
        $linked = new Libs\Link();
        $note = '';
        $who = $linked->getAsRecord($slug);
        if (!empty($who)) {
            $note = $who->note;
        }

        return $this->render('addresses/note.html.twig', [
            'controller_name' => 'AddressController',
            'note' => $note,
        ]);
    }

    /**
     * @param int $id
     * @throws \kalanis\kw_mapper\MapperException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove(int $id)
    {
        $record = new Libs\Mappers\AddressRecord();
        $record->id = $id;

        if (0 < $record->count()) {
            $record->load();
            $record->deleted = date('Y-m-d H:i:s');
            $record->save();
        }

        return $this->fw();
    }

    /**
     * Steps forward
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function fw()
    {
        $fw = new Forward();
        $fw->setSource(new Sources\Inputs($this->inputVariables()));
        return $this->redirect($fw->has() ? $fw->get() : '/');
    }

    /**
     * @return Variables
     * @todo: create class for transformation of _VARS from Symfony to kw_* so it shouldn't be necessary to use original inputs
     */
    protected function inputVariables()
    {
        $inputs = new Inputs();
        $inputs->setSource([])->loadEntries();
        return new Variables($inputs);
    }
}

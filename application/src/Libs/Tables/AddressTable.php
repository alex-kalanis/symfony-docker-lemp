<?php

namespace App\Libs\Tables;


use App\Libs\Link;
use kalanis\kw_address_handler\Forward;
use kalanis\kw_address_handler\Handler;
use kalanis\kw_address_handler\Sources;
use kalanis\kw_connect\core\ConnectException;
use kalanis\kw_forms\Adapters;
use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_forms\Form;
use kalanis\kw_input\Interfaces\IFiltered;
use kalanis\kw_input\Interfaces as InputInterface;
use kalanis\kw_mapper\Interfaces\IQueryBuilder;
use kalanis\kw_mapper\Search\Search;
use kalanis\kw_pager\BasicPager;
use kalanis\kw_paging\Positions;
use kalanis\kw_paging\Render;
use kalanis\kw_table\core\Connector\PageLink;
use kalanis\kw_table\core\Table;
use kalanis\kw_table\core\Table\Order;
use kalanis\kw_table\core\TableException;
use kalanis\kw_table\core\Table\Columns;
use kalanis\kw_table\core\Table\Rules;
use kalanis\kw_table\form_kw\Fields as KwField;
use kalanis\kw_table\form_kw\KwFilter;
use kalanis\kw_table\output_cli\CliRenderer;


/**
 * Class AddressTable
 * @package App\Libs\Tables
 * Complete address table description
 */
class AddressTable
{
    /** @var IFiltered */
    protected $variables = null;
    /** @var Table */
    protected $table = null;
    /** @var Forward */
    protected $forward = null;
    /** @var Link */
    protected $link = null;

    /**
     * @param IFiltered $inputs
     */
    public function __construct(IFiltered $inputs)
    {
        $this->variables = $inputs;
        $this->forward = new Forward();
        $this->link = new Link();
    }

    /**
     * @param Search $search
     * @throws FormsException
     * @throws TableException
     */
    public function composeWeb(Search $search): void
    {
        $helper = new \kalanis\kw_table\kw\Helper();
        $helper->fillKwPage($this->variables);
        $this->table = $helper->getTable();

        $this->table->setDefaultHeaderFilterFieldAttributes(['style' => 'width:100%']);

        // columns
        $this->table->addOrderedColumn('ID', new Columns\Func('id', [$this, 'idLink']), new KwField\TextExact());
        $this->table->addOrderedColumn('First name', new Columns\Bold('firstName'), new KwField\TextContains());
        $this->table->addOrderedColumn('Last name', new Columns\Basic('lastName'), new KwField\TextContains());
        $this->table->addOrderedColumn('Phone', new Columns\Basic('phone'), new KwField\TextContains());
        $this->table->addOrderedColumn('Email', new Columns\Basic('email'), new KwField\TextContains());

        $columnActions = new Columns\Multi('&nbsp;&nbsp;', 'id');
        $columnActions->addColumn(new Columns\Func('id', [$this, 'editLink']));
        $columnActions->addColumn(new Columns\Func('id', [$this, 'noteLink']));
        $columnActions->addColumn(new Columns\Func('id', [$this, 'deleteLink']));
        $columnActions->style('width:200px', new Rules\Always());

        $this->table->addColumn('Actions', $columnActions);

        // sorting and connecting datasource
        $this->table->addOrdering('id',IQueryBuilder::ORDER_DESC);
        $this->table->addDataSetConnector(new \kalanis\kw_connect\search\Connector($search));

        // records per page
        $this->table->getPager()->getPager()->setLimit(10);
    }

    /**
     * @param Search $search
     * @throws FormsException
     * @throws TableException
     */
    public function composeCli(Search $search): void
    {
        $this->fillKwCli($this->variables);

        // columns
        $this->table->addOrderedColumn('ID', new Columns\Basic('id'), new KwField\TextExact());
        $this->table->addOrderedColumn('First name', new Columns\Basic('firstName'), new KwField\TextContains());
        $this->table->addOrderedColumn('Last name', new Columns\Basic('lastName'), new KwField\TextContains());
        $this->table->addOrderedColumn('Phone', new Columns\Basic('phone'), new KwField\TextContains());
        $this->table->addOrderedColumn('Email', new Columns\Basic('email'), new KwField\TextContains());

        // sorting and connecting datasource
        $this->table->addOrdering('id',IQueryBuilder::ORDER_DESC);
        $this->table->addDataSetConnector(new \kalanis\kw_connect\search\Connector($search));

        // records per page
        $this->table->getPager()->getPager()->setLimit(10);
    }

    protected function fillKwCli(InputInterface\IFiltered $inputs, string $alias = 'filter'): void
    {
        $this->table = new Table();

        // filter form
        $inputVariables = new InputVarsAdapter($inputs);
        $inputFiles = new Adapters\InputFilesAdapter($inputs);
        $form = new Form($alias);
        $form->setMethod(InputInterface\IEntry::SOURCE_CLI); // set Cli as input
        $this->table->addHeaderFilter(new KwFilter($form));
        $form->setInputs($inputVariables, $inputFiles);

        // order links
        $this->table->addOrder(new Order(new Handler(new Sources\Inputs($inputs))));

        // pager
        $pager = new BasicPager();
        $pageLink = new PageLink(new Handler(new Sources\Inputs($inputs)), $pager);
        $pager->setActualPage($pageLink->getPageNumber());
        $this->table->addPager(new Render\CliPager(new Positions($pager)));

        // output
        $this->table->setOutput(new CliRenderer($this->table));

    }

    public function idLink($id): string
    {
        $data = $this->table->getDataSetConnector()->getByKey($id);
        $this->forward->setLink('/' . $this->link->getAsLink($data->getValue('firstName'), $data->getValue('lastName')));
        $this->forward->setForward('/');
        return sprintf('<a href="%s" class="button">%s</a>',
            $this->forward->getLink(),
            strval($id)
        );
    }

    public function editLink($id): string
    {
        $data = $this->table->getDataSetConnector()->getByKey($id);
        $this->forward->setLink('/' . $this->link->getAsLink($data->getValue('firstName'), $data->getValue('lastName')));
        $this->forward->setForward('/');
        return sprintf('<a href="%s" title="%s" class="button button-edit"> &#x1F589; </a>',
            $this->forward->getLink(),
            'Update'
        );
    }

    public function deleteLink($id): string
    {
        $this->forward->setLink('/remove/' . $id);
        $this->forward->setForward('/');
        return sprintf('<a href="%s" title="%s" class="button button-delete"> &#x1F7AE; </a>',
            $this->forward->getLink(),
            'Delete'
        );
    }

    public function noteLink($id): string
    {
        $data = $this->table->getDataSetConnector()->getByKey($id);
        return sprintf('<a data-title="%s" class="button modal-window"> ? </a>',
            urlencode($data->getValue('note'))
        );
    }

    /**
     * @throws TableException
     * @throws ConnectException
     * @return string
     */
    public function __toString()
    {
        return $this->table->render();
    }

    public function getTable(): Table
    {
        return $this->table;
    }
}

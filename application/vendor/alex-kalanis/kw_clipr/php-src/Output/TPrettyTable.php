<?php

namespace kalanis\kw_clipr\Output;


/**
 * Trait TPrettyTable
 * @package kalanis\kw_clipr\Output
 * @property bool $quiet
 */
trait TPrettyTable
{
    /**
     * @var PrettyTable
     */
    protected $prettyTable = null;

    public function setTableColors($values): void
    {
        $this->init();
        $this->prettyTable->setColors($values);
    }

    public function setTableColorsHeader($values): void
    {
        $this->init();
        $this->prettyTable->setColorsHeader($values);
    }

    public function setTableHeaders($values): void
    {
        $this->init();
        $this->prettyTable->setHeaders($values);
    }

    public function setTableDataLine($values): void
    {
        $this->init();
        $this->prettyTable->setDataLine($values);
    }

    private function init(): void
    {
        if (empty($this->prettyTable)) {
            $this->prettyTable = new PrettyTable();
        }
    }

    public function resetTable(): void
    {
        $this->prettyTable = null;
    }

    public function dumpTable(bool $displayHeader = true, bool $linesAround = true): void
    {
        if ($linesAround) {
            $this->writeLn($this->prettyTable->getSeparator());
        }
        if ($displayHeader) {
            $this->writeLn($this->prettyTable->getHeader());
            $this->writeLn($this->prettyTable->getSeparator());
        }
        foreach ($this->prettyTable as $row) {
            $this->writeLn($row);
        }
        if ($linesAround) {
            $this->writeLn($this->prettyTable->getSeparator());
        }
        $this->resetTable();
    }

    abstract public function writeLn(string $output = ''): void;
}

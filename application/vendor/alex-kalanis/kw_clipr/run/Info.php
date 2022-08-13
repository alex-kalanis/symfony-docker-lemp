<?php

namespace clipr;


use kalanis\kw_clipr\Clipr\Useful;
use kalanis\kw_clipr\Output\TPrettyTable;
use kalanis\kw_clipr\Tasks\ATask;
use kalanis\kw_clipr\Tasks\Params;


class Info extends ATask
{
    use TPrettyTable;

    public function desc(): string
    {
        return 'Info about Clipr and its inputs';
    }

    public function process(): void
    {
        $cliprPath = Useful::getNthParam($this->inputs->getInArray(), 0) ?? 'clipr';
        $this->writeLn('<yellow><bluebg>+======================+</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>|       kw_clipr       |</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>+======================+</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>|  Info about system   |</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>+======================+</bluebg></yellow>');
        $this->writeLn();
        $this->writeLn('kw_clipr is a simple framework for running tasks from CLI.');
        $this->writeLn('It calls task from predefined sources and allows them to run.');
        $this->writeLn('Command line query is simple - "clipr task --rest-of-params"');
        $this->writeLn('For list available tasks use following command:');
        $this->writeLn("<lcyan>$cliprPath clipr/Lister</lcyan>");
        $this->writeLn('For info about task use following command:');
        $this->writeLn("<lcyan>$cliprPath clipr/Help task</lcyan>");
        $this->writeLn('Help inside the task might show other things. That depends on task author.');
        $this->writeLn('Also color output depends on task author. And your terminal.');
        $this->writeLn();
        $this->writeLn('And this is list of default variables available for each task:');
        $this->setTableHeaders(['local variables', 'cli key', 'current value']);
        foreach ($this->params->getAvailableOptions() as $option) {
            /** @var Params\Option $option */
            $this->setTableDataLine([$option->getVariable(), $option->getCliKey(), $option->getValue()]);
        }
        $this->dumpTable();
    }
}

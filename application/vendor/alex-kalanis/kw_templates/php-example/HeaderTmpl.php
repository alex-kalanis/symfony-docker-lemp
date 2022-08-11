<?php

namespace kalanis\kw_templates\example;


use kalanis\kw_templates\ATemplate;
use kalanis\kw_templates\Template\TFile;


class HeaderTmpl extends ATemplate
{
    use TFile;

    protected function templatePath(): string
    {
        // get path to file - shared between languages
        return realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'shared-example', 'header.html']));
    }

    protected function fillInputs(): void
    {
        // set which keys will be looked for and what default values they will need
        // usually it's good thing to set default values as some main language
        $this->addInput('{TITLE}', 'Example for %s', 'Example for loading');
        $this->addInput('{ENCODING}', 'utf-8');
        $this->addInput('{CONTENT}', 'HTML page - example of filling with these templates.');
    }

    public function setData(): void
    {
        // this is example how to update values
        $this->getItem('{ENCODING}')->setValue('win-1250');
        // another way is re-set them
        $this->updateItem('{CONTENT}', 'HTML - updated after load, not before');
        // last one is to change values depending on state of code
        $input = $this->getItem('{ENCODING}');
        $input->setValue(sprintf($input->getDefault(), 'running'));
        $input->updateValue('trash');

        // now just call HeaderTmpl->render() and dump output where you wish
    }
}

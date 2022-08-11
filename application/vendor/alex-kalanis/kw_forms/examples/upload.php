<?php

namespace kalanis\kw_forms\examples;


use kalanis\kw_forms\Adapters\FilesAdapter;
use kalanis\kw_forms\Adapters\VarsAdapter;
use kalanis\kw_forms\Form;
use kalanis\kw_rules\Interfaces\IRules;


class UploadForm extends Form
{
    public function set(): self
    {
        $this->setMethod(VarsAdapter::SOURCE_POST);
        $this->addFile('file', 'Uploaded file')
            ->addRule(IRules::FILE_RECEIVED, 'Must be send');
        $this->addSubmit('upload', 'Upload');
        return $this;
    }
}


$upload = new UploadForm('upload');
$upload->set();
$upload->setInputs(new VarsAdapter(), new FilesAdapter());

if ($upload->process()) {
    $upload->getValues();
    // process things from form
}

$upload->render();

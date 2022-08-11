<?php

namespace kalanis\kw_forms\examples;


use kalanis\kw_forms\Adapters\VarsAdapter;
use kalanis\kw_forms\Form;
use kalanis\kw_rules\Interfaces\IRules;


class BlogForm extends Form
{
    public function set(): self
    {
        $this->setMethod(VarsAdapter::SOURCE_POST);
        $this->addTextarea('content', 'Your message')
            ->addRule(IRules::IS_NOT_EMPTY, 'Must be filled');
        $this->addSubmit('save', 'Save');
        return $this;
    }
}


$blog = new BlogForm('blog');
$blog->set();
$blog->setInputs(new VarsAdapter());

if ($blog->process()) {
    $blog->getValues();
    // process things from form
}

$blog->render();

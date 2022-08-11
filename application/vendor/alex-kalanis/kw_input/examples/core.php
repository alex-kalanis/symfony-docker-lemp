<?php

/**
 * Example cores for show how to connect inputs into your app
 */
use kalanis\kw_input\Inputs;


class Core1
{
    protected $inputs = null;

    /// ...

    public function setInputs(Inputs $inputs)
    {
        $this->inputs = $inputs;
    }

    /// ...
}


class Core2
{
    protected $inputs = null;

    public function __construct(array $cliArgs = [])
    {
        $this->inputs = new Inputs();
        $this->inputs->setSource($cliArgs)->loadEntries();
        /// ...
    }

    /// ...
}

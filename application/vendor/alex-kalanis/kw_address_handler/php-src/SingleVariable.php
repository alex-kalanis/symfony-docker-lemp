<?php

namespace kalanis\kw_address_handler;


/**
 * Class SingleVariable
 * @package kalanis\kw_address_handler
 * Process single defined parameter in address inside the params
 */
class SingleVariable
{
    /** @var Params */
    protected $params = null;
    /** @var string */
    protected $variableValue = '';
    /** @var string */
    protected $variableName = 'variable';

    public function __construct(Params $params)
    {
        $this->params = $params;
    }

    public function setVariableName(string $name): self
    {
        $this->variableName = $name;
        return $this;
    }

    public function getVariableName(): string
    {
        return $this->variableName;
    }

    public function setVariableValue(string $value): self
    {
        $this->params->offsetSet($this->variableName, $value);
        return $this;
    }

    public function getVariableValue(): string
    {
        return strval($this->params->offsetGet($this->variableName));
    }
}

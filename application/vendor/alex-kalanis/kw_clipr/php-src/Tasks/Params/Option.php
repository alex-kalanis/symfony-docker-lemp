<?php

namespace kalanis\kw_clipr\Tasks\Params;


/**
 * Class Option
 * @package kalanis\kw_clipr\Tasks\Params
 */
class Option
{
    /** @var string */
    protected $variable = '';
    /** @var string */
    protected $cliKey = '';
    /** @var string|null */
    protected $match = '';
    /** @var mixed */
    protected $defaultValue = null;
    /** @var mixed */
    protected $value = null;
    /** @var string|null */
    protected $short = null;
    /** @var string */
    protected $description = '';

    /**
     * @param string $variable
     * @param string $cliKey
     * @param string|null $match
     * @param mixed $defaultValue
     * @param string|null $short
     * @param string $description
     * @return $this
     */
    public function setData(string $variable, string $cliKey, ?string $match, $defaultValue = null, ?string $short = null, string $description = ''): self
    {
        $this->variable = $variable;
        $this->cliKey = $cliKey;
        $this->match = $match;
        $this->short = $short;
        $this->description = $description;
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getVariable(): string
    {
        return $this->variable;
    }

    public function getCliKey(): string
    {
        return $this->cliKey;
    }

    public function getMatch(): ?string
    {
        return $this->match;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

<?php

namespace kalanis\kw_templates\Template;


class Item
{
    /** @var string */
    protected $key = '';
    /** @var string */
    protected $default = '';
    /** @var string|null */
    protected $value = null;

    public function setData(string $key, string $default = ''): self
    {
        $this->key = $key;
        $this->default = $default;
        return $this;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param bool|float|int|string|null ...$arg
     * @return $this
     */
    public function updateValue(...$arg): self
    {
        $this->value = sprintf($this->getValue(), ...$arg);
        return $this;
    }

    public function getKey(): string
    {
        return $this->key ;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function getValue(): string
    {
        return $this->value ?? $this->default ;
    }
}

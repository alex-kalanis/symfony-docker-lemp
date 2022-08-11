<?php

namespace kalanis\kw_clipr\Tasks;


use kalanis\kw_input\Interfaces\IEntry;
use Traversable;


/**
 * Class Params
 * @package kalanis\kw_clipr\Tasks
 * Paths to accessing tasks/commands somewhere on volumes
 */
class Params
{
    /** @var array<string, IEntry> */
    protected $inputs = [];
    /** @var array<string, Params\Option> */
    protected $available = [];

    /**
     * @param array<IEntry> $inputs
     */
    public function __construct(array &$inputs)
    {
        $this->inputs = array_combine(array_map([$this, 'getKey'], $inputs), $inputs);
    }

    /**
     * @codeCoverageIgnore why someone would run that?!
     */
    private function __clone()
    {
    }

    public function getKey(IEntry $entry): string
    {
        return $entry->getKey();
    }

    /**
     * @param string $variable
     * @param string $cliKey
     * @param string|null $match
     * @param array|bool|mixed|string|null $defaultValue
     * @param string|null $short
     * @param string $desc
     * @return Params
     */
    public function addParam(string $variable, string $cliKey, ?string $match = null, $defaultValue = null, ?string $short = null, string $desc = ''): self
    {
        $param = new Params\Option();
        $param->setData($variable, $cliKey, $match, $defaultValue, $short, $desc);
        $param->setValue($this->whichVariant($param));
        $this->available[$variable] = $param;
        return $this;
    }

    /**
     * @param Params\Option $param
     * @return array|bool|mixed|string|null
     */
    protected function whichVariant(Params\Option $param)
    {
        if (isset($this->inputs[$param->getCliKey()])) {
            $input = $this->inputs[$param->getCliKey()];

            if (!is_null($param->getMatch())) {
                $matches = [];
                if (preg_match($param->getMatch(), trim($input->getValue()), $matches)) {
                    if (1 == count($matches)) { // no submatch set
                        return reset($matches);
                    } elseif (2 == count($matches)) { // one submatch set
                        reset($matches);
                        return next($matches);
                    } else { // more than one submatch
                        return $matches;
                    }
                } else {
                    return $param->getDefaultValue();
                }
            } else {
                return (is_bool($param->getDefaultValue())) ? (false === $param->getDefaultValue()) : $input->getValue();
            }
        } elseif (isset($this->inputs[$param->getShort()])) {
            return empty($param->getDefaultValue());
        } else {
            return $param->getDefaultValue();
        }
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->__isset($name) ? $this->available[$name]->getValue() : null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->available[$name]);
    }

    /**
     * @return Traversable<string, Params\Option>
     */
    public function getAvailableOptions(): Traversable
    {
        yield from $this->available;
    }
}

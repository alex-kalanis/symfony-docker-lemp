<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Exceptions\RuleException;


/**
 * trait TCheckRange
 * @package kalanis\kw_rules\Rules
 * Check original values as range
 */
trait TCheckRange
{
    use TRule;

    /**
     * @param mixed|null $againstValue
     * @throws RuleException
     * @return array<int>
     */
    protected function checkValue($againstValue)
    {
        if (!is_array($againstValue)) {
            throw new RuleException('No array found. Need set both values to compare!');
        }
        $values = array_map([$this, 'checkRule'], $againstValue);
        $lower = intval(min($values));
        $higher = intval(max($values));
        return [$lower, $higher];
    }

    /**
     * @param mixed|null $againstValue
     * @throws RuleException
     * @return int
     */
    protected function checkRule($againstValue): int
    {
        if (is_array($againstValue)) {
            throw new RuleException('Sub-array found. Need set only values to compare!');
        }
        if (is_object($againstValue)) {
            throw new RuleException('Object found. Need set only values to compare!');
        }
        return intval(strval($againstValue));
    }
}

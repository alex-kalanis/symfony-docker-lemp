<?php

namespace kalanis\kw_rules\Rules;


use kalanis\kw_rules\Interfaces\IRuleFactory;
use kalanis\kw_rules\Interfaces\IRules;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class Factory
 * @package kalanis\kw_rules\Rules
 * Factory for getting rules
 */
class Factory implements IRuleFactory
{
    /** @var array<string, string> */
    protected static $map = [
        IRules::MATCH_ALL              => '\kalanis\kw_rules\Rules\MatchAll',
        IRules::MATCH_ANY              => '\kalanis\kw_rules\Rules\MatchAny',
        IRules::MATCH_ENTRY            => '\kalanis\kw_rules\Rules\MatchByEntry',
        IRules::ALWAYS                 => '\kalanis\kw_rules\Rules\Always',
        IRules::EQUALS                 => '\kalanis\kw_rules\Rules\Equals',
        IRules::NOT_EQUALS             => '\kalanis\kw_rules\Rules\NotEquals',
        IRules::IN_ARRAY               => '\kalanis\kw_rules\Rules\IsInArray',
        IRules::NOT_IN_ARRAY           => '\kalanis\kw_rules\Rules\IsNotInArray',
        IRules::IS_GREATER_THAN        => '\kalanis\kw_rules\Rules\GreaterThan',
        IRules::IS_LOWER_THAN          => '\kalanis\kw_rules\Rules\LesserThan',
        IRules::IS_GREATER_THAN_EQUALS => '\kalanis\kw_rules\Rules\GreaterEquals',
        IRules::IS_LOWER_THAN_EQUALS   => '\kalanis\kw_rules\Rules\LesserEquals',
        IRules::IS_NUMERIC             => '\kalanis\kw_rules\Rules\IsNumeric',
        IRules::IS_STRING              => '\kalanis\kw_rules\Rules\IsString',
        IRules::IS_BOOL                => '\kalanis\kw_rules\Rules\IsBool',
        IRules::MATCHES_PATTERN        => '\kalanis\kw_rules\Rules\MatchesPattern',
        IRules::LENGTH_MIN             => '\kalanis\kw_rules\Rules\LengthMin',
        IRules::LENGTH_MAX             => '\kalanis\kw_rules\Rules\LengthMax',
        IRules::LENGTH_EQUALS          => '\kalanis\kw_rules\Rules\LengthEquals',
        IRules::IN_RANGE               => '\kalanis\kw_rules\Rules\InRange',
        IRules::IN_RANGE_EQUALS        => '\kalanis\kw_rules\Rules\InRangeEquals',
        IRules::NOT_IN_RANGE           => '\kalanis\kw_rules\Rules\OutRange',
        IRules::NOT_IN_RANGE_EQUALS    => '\kalanis\kw_rules\Rules\OutRangeEquals',
        IRules::IS_FILLED              => '\kalanis\kw_rules\Rules\IsFilled',
        IRules::IS_NOT_EMPTY           => '\kalanis\kw_rules\Rules\IsFilled',
        IRules::IS_EMPTY               => '\kalanis\kw_rules\Rules\IsEmpty',
        IRules::SATISFIES_CALLBACK     => '\kalanis\kw_rules\Rules\ProcessCallback',
        IRules::IS_EMAIL               => '\kalanis\kw_rules\Rules\IsEmail',
        IRules::IS_DOMAIN              => '\kalanis\kw_rules\Rules\IsDomain',
        IRules::IS_ACTIVE_DOMAIN       => '\kalanis\kw_rules\Rules\IsActiveDomain',
        IRules::URL_EXISTS             => '\kalanis\kw_rules\Rules\UrlExists',
        IRules::IS_JSON_STRING         => '\kalanis\kw_rules\Rules\IsJsonString',
//        IRules::IS_POST_CODE           => '\kalanis\kw_rules\Rules\External\IsPostCode',  // too many formats for simple check, use regex
//        IRules::IS_TELEPHONE           => '\kalanis\kw_rules\Rules\External\IsPhone',  // too many formats for simple check, use regex
//        IRules::IS_EU_VAT              => '\kalanis\kw_rules\Rules\External\IsEuVat',  // too many formats, needs some library for checking
        IRules::IS_DATE                => '\kalanis\kw_rules\Rules\External\IsDate',  // too many formats, needs some library for checking
        IRules::IS_DATE_REGEX          => '\kalanis\kw_rules\Rules\External\IsDateRegex',  // too many formats, needs some library for checking
        IRules::SAFE_EQUALS_BASIC      => '\kalanis\kw_rules\Rules\Safe\HashedBasicEquals',
        IRules::SAFE_EQUALS_FUNC       => '\kalanis\kw_rules\Rules\Safe\HashedFuncEquals',
        IRules::SAFE_EQUALS_PASS       => '\kalanis\kw_rules\Rules\Safe\HashedPassEquals',
    ];

    /**
     * @param string $ruleName
     * @throws RuleException
     * @return ARule
     */
    public function getRule(string $ruleName): ARule
    {
        if (isset(static::$map[$ruleName])) {
            $rule = static::$map[$ruleName];
            $class = new $rule();
            if ($class instanceof ARule) {
                return $class;
            }
        }
        throw new RuleException(sprintf('Unknown rule %s', $ruleName));
    }
}

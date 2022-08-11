<?php

namespace kalanis\kw_rules\Rules\File;


use kalanis\kw_rules\Interfaces\IRuleFactory;
use kalanis\kw_rules\Interfaces\IRules;
use kalanis\kw_rules\Exceptions\RuleException;


/**
 * Class Factory
 * @package kalanis\kw_rules\Rules\File
 * Factory for getting rules for files
 */
class Factory implements IRuleFactory
{
    /** @var array<string, string> */
    protected static $map = [
        IRules::FILE_EXISTS             => '\kalanis\kw_rules\Rules\File\FileExists',
        IRules::FILE_SENT               => '\kalanis\kw_rules\Rules\File\FileSent',
        IRules::FILE_RECEIVED           => '\kalanis\kw_rules\Rules\File\FileReceived',
        IRules::FILE_MAX_SIZE           => '\kalanis\kw_rules\Rules\File\FileMaxSize',
        IRules::FILE_MIMETYPE_EQUALS    => '\kalanis\kw_rules\Rules\File\FileMimeEquals',
        IRules::FILE_MIMETYPE_IN_LIST   => '\kalanis\kw_rules\Rules\File\FileMimeList',
        IRules::IS_IMAGE                => '\kalanis\kw_rules\Rules\File\ImageIs',
        IRules::IMAGE_DIMENSION_EQUALS  => '\kalanis\kw_rules\Rules\File\ImageSizeEquals',
        IRules::IMAGE_DIMENSION_IN_LIST => '\kalanis\kw_rules\Rules\File\ImageSizeList',
        IRules::IMAGE_MAX_DIMENSION     => '\kalanis\kw_rules\Rules\File\ImageSizeMax',
        IRules::IMAGE_MIN_DIMENSION     => '\kalanis\kw_rules\Rules\File\ImageSizeMin',
    ];

    /**
     * @param string $ruleName
     * @throws RuleException
     * @return AFileRule
     */
    public function getRule(string $ruleName): AFileRule
    {
        if (isset(static::$map[$ruleName])) {
            $rule = static::$map[$ruleName];
            $class = new $rule();
            if ($class instanceof AFileRule) {
                return $class;
            }
        }
        throw new RuleException(sprintf('Unknown rule %s', $ruleName));
    }
}

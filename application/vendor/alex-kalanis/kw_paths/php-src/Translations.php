<?php

namespace kalanis\kw_paths;


use kalanis\kw_paths\Interfaces\IPATranslations;


/**
 * Class Translations
 * @package kalanis\kw_paths
 * Translations
 */
class Translations implements IPATranslations
{
    public function paCannotCreateDescDir(): string
    {
        return 'Cannot create description dir';
    }

    public function paCannotCreateThumbDir(): string
    {
        return 'Cannot create thumbnail dir';
    }

    public function paCannotAccessWantedDir(): string
    {
        return 'Cannot access wanted directory!';
    }

    public function paCannotWriteIntoDir(): string
    {
        return 'Cannot write into that directory!';
    }

    public function paUserNameIsShort(): string
    {
        return 'Username is short!';
    }

    public function paUserNameContainsChars(): string
    {
        return 'Username contains unsupported characters!';
    }

    public function paUserNameNotDefined(): string
    {
        return 'Necessary user name is not defined!';
    }

    public function paCannotDetermineUserDir(): string
    {
        return 'Cannot determine user dir!';
    }

    public function paCannotCreateUserDir(): string
    {
        return 'Cannot create user dir!';
    }
}

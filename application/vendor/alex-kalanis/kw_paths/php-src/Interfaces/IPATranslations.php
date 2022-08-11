<?php

namespace kalanis\kw_paths\Interfaces;


/**
 * Interface IPATranslations
 * @package kalanis\kw_paths\Interfaces
 * Translations
 */
interface IPATranslations
{
    public function paCannotCreateDescDir(): string;

    public function paCannotCreateThumbDir(): string;

    public function paCannotAccessWantedDir(): string;

    public function paCannotWriteIntoDir(): string;

    public function paUserNameIsShort(): string;

    public function paUserNameContainsChars(): string;

    public function paUserNameNotDefined(): string;

    public function paCannotDetermineUserDir(): string;

    public function paCannotCreateUserDir(): string;
}

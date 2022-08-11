<?php

namespace kalanis\kw_locks\Interfaces;


/**
 * Interface IKLTranslations
 * @package kalanis\kw_locks\Interfaces
 * Translations
 */
interface IKLTranslations
{
    public function iklLockedByOther(): string;

    public function iklProblemWithStorage(): string;

    public function iklCannotUseFile(string $lockFilename): string;

    public function iklCannotUsePath(string $path): string;

    public function iklCannotOpenFile(string $lockFilename): string;

    public function iklCannotUseOS(): string;
}

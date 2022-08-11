<?php

namespace kalanis\kw_locks\Methods;


use kalanis\kw_locks\Interfaces\IKLTranslations;


/**
 * Class StorageLock
 * @package kalanis\kw_locks\Methods
 */
class Translations implements IKLTranslations
{
    public function iklLockedByOther(): string
    {
        return 'Locked by another!';
    }

    public function iklProblemWithStorage(): string
    {
        return 'Problem with storage';
    }

    public function iklCannotUseFile(string $lockFilename): string
    {
        return 'Cannot use: ' . $lockFilename . ' as lock file. Path is not writable.';
    }

    public function iklCannotUsePath(string $path): string
    {
        return 'Cannot use: ' . $path . ' to lock. Path not found and cannot be created.';
    }

    public function iklCannotOpenFile(string $lockFilename): string
    {
        return 'Could not open lock file: '. $lockFilename;
    }

    public function iklCannotUseOS(): string
    {
        return 'Unusable OS. Cannot use external programs to determine process ID.';
    }
}

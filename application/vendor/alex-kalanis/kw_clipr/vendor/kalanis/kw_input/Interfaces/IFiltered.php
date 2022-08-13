<?php

namespace kalanis\kw_input\Interfaces;


use ArrayAccess;


/**
 * Interface IVariables
 * @package kalanis\kw_input
 * Helper interface which allows us access variables from input
 */
interface IFiltered
{
    /**
     * Reformat into array with key as array key and value with the whole entry
     * @param string|null $entryKey
     * @param string[] $entrySources
     * @return IEntry[]
     * Also usually came in pair with previous call - but with a different syntax
     * Beware - due any dict limitations there is a limitation that only the last entry prevails
     *
     * $entries = $variables->getInArray('example', [Entries\IEntry::SOURCE_GET]);
     */
    public function getInArray(?string $entryKey = null, array $entrySources = []): array;

    /**
     * Reformat into object with access by key as string key and value with the whole entry
     * @param string|null $entryKey
     * @param string[] $entrySources
     * @return ArrayAccess
     * Also usually came in pair with previous call - but with a different syntax
     * Beware - due any dict limitations there is a limitation that only the last entry prevails
     *
     * $entriesInObject = $variables->getInObject('example', [Entries\IEntry::SOURCE_GET]);
     */
    public function getInObject(?string $entryKey = null, array $entrySources = []): ArrayAccess;
}

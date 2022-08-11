<?php

namespace kalanis\kw_input\Loaders;


use kalanis\kw_input\Entries;


/**
 * Class File
 * @package kalanis\kw_input\Loaders
 * Load file input array into normalized entries
 * @link https://www.php.net/manual/en/reserved.variables.files.php
 */
class File extends ALoader
{
    public function loadVars(string $source, $array): array
    {
        $entries = new Entries\FileEntry();
        $result = [];
        foreach ($array as $postedKey => $posted) {
            if (is_array($posted['name'])) {
                foreach ($posted['name'] as $key => $value) {
                    $entry = clone $entries;
                    $entry->setEntry($source, sprintf('%s[%s]', $postedKey, $key));
                    $entry->setFile(
                        $value,
                        $posted['tmp_name'][$key],
                        $posted['type'][$key],
                        intval($posted['error'][$key]),
                        intval($posted['size'][$key])
                    );
                    $result[] = $entry;
                }
            } else {
                $entry = clone $entries;
                $entry->setEntry($source, $postedKey);
                $entry->setFile(
                    $posted['name'],
                    $posted['tmp_name'],
                    $posted['type'],
                    intval($posted['error']),
                    intval($posted['size'])
                );
                $result[] = $entry;
            }
        }
        return $result;
    }
}

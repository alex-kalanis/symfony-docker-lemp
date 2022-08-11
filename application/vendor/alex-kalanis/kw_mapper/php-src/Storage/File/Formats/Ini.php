<?php

namespace kalanis\kw_mapper\Storage\File\Formats;


use kalanis\kw_mapper\Interfaces\IFileFormat;
use kalanis\kw_mapper\MapperException;


/**
 * Class Ini
 * @package kalanis\kw_mapper\Storage\File\Formats
 * Formats/unpack content into/from table created by separated elements in ini/inf file
 */
class Ini implements IFileFormat
{
    use TNl;

    public function unpack(string $content): array
    {
        $lines = @parse_ini_string($content, true);
        if (false === $lines) {
            throw new MapperException('Cannot parse INI input');
        }
        $records = [];
        foreach ($lines as $key => &$line) {
            $records[$key] = array_map([$this, 'unescapeNl'], $line);
        }
        return $records;
    }

    public function pack(array $records): string
    {
        $lines = [];
        foreach ($records as $key => &$record) {
            $lines[$key] = array_map([$this, 'escapeNl'], (array) $record);
        }
        return $this->write_ini_string($lines);
    }

    /**
     * Write an ini configuration file
     * @param array<string|int, string|int|float|array<string|int, string|int|array<string|int, string|int>>> $array
     * @return string
     * @link https://stackoverflow.com/questions/5695145/how-to-read-and-write-to-an-ini-file-with-php
     * @codeCoverageIgnore I have zero morale to check this one
     */
    protected function write_ini_string(array $array): string
    {
        // process array
        $data = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $data[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    if (is_array($sval)) {
                        foreach ($sval as $_skey => $_sval) {
                            if (is_numeric($_skey)) {
                                $data[] = $skey.'[] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            } else {
                                $data[] = $skey.'['.$_skey.'] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            }
                        }
                    } else {
                        $data[] = $skey.' = '.(is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"'.$sval.'"'));
                    }
                }
            } else {
                $data[] = $key.' = '.(is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"'.$val.'"'));
            }
            // empty line
            $data[] = null;
        }

        return implode(PHP_EOL, $data) . PHP_EOL;
    }
}

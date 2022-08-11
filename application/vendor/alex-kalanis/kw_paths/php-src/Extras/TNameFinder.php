<?php

namespace kalanis\kw_paths\Extras;


use kalanis\kw_paths\Interfaces\IPaths;
use kalanis\kw_paths\Stuff;


/**
 * trait TNameFinder
 * @package kalanis\kw_paths\Extras
 * Find free name for file
 */
trait TNameFinder
{
    public function findFreeName(string $name): string
    {
        $name = Stuff::canonize($name);
        $ext = Stuff::fileExt($name);
        if (0 < strlen($ext)) {
            $ext = IPaths::SPLITTER_DOT . $ext;
        }
        $fileName = Stuff::fileBase($name);
        if (!$this->targetExists($this->getTargetDir() . $fileName . $ext)) {
            return $fileName . $ext;
        }
        $i = 0;
        while ($this->targetExists($this->getTargetDir() . $fileName . $this->getSeparator() . $i . $ext)) {
            $i++;
        }
        return $fileName . $this->getSeparator() . $i . $ext;
    }

    abstract protected function getSeparator(): string;

    abstract protected function getTargetDir(): string;

    abstract protected function targetExists(string $path): bool;
}

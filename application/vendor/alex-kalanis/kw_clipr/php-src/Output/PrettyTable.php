<?php

namespace kalanis\kw_clipr\Output;


use kalanis\kw_clipr\Clipr\Useful;


/**
 * Class PrettyTable
 *
 * Lib which makes pretty tables (Markdown rulezz!)
 *
 * Usage (basically twice, once set, then output):
 * <pre>
 *   # set
 *   $libPrettyTable = new PrettyTable();
 *   $libPrettyTable->setHeaders(['tb1','tb2','tb3']);
 *   $libPrettyTable->setColors(['yellow','','blue']);
 *   $libPrettyTable->setDataLine(['abc','def','ghi']);
 *   $libPrettyTable->setDataLine(['rst','uvw','xyz']);
 *   # print
 *   cliprATask->outputLn($libPrettyTable->getHeader());
 *   cliprATask->outputLn($libPrettyTable->getSeparator());
 *   foreach ($libPrettyTable as $row) {
 *       cliprATask->outputLn($row);
 *   }
 * </pre>
 * @package kalanis\kw_clipr\Output
 */
class PrettyTable implements \Iterator
{
    /** @var array<int, string> */
    protected $header = [];
    /** @var array<int, string> */
    protected $colors = [];
    /** @var array<int, string> */
    protected $colorsHeader = [];
    /** @var array<int, array<int, string>> */
    protected $table = [];
    /** @var int */
    protected $position = 0;
    /** @var array<int, int> */
    protected $lengths = [];

    /**
     * @param array<int, string> $values
     */
    public function setColors($values): void
    {
        $this->colors = $values;
    }

    public function setColor(int $index, string $value): void
    {
        $this->colors[$index] = $value;
    }

    /**
     * @param array<int, string> $values
     */
    public function setColorsHeader($values): void
    {
        $this->colorsHeader = $values;
    }

    public function setColorHeader(int $index, string $value): void
    {
        $this->colorsHeader[$index] = $value;
    }

    /**
     * @param array<int, string> $values
     */
    public function setHeaders($values): void
    {
        $this->header = $values;
    }

    public function setHeader(int $index, string $value): void
    {
        $this->header[$index] = $value;
    }

    /**
     * @param array<int, string> $values
     */
    public function setDataLine($values): void
    {
        $this->table[$this->position] = $values;
        $this->next();
    }

    /**
     * @param int $index
     * @param string $value
     */
    public function setData(int $index, $value): void
    {
        $this->table[$this->position][$index] = $value;
    }

    public function setLengths(bool $force = false): void
    {
        if (empty($this->lengths) || $force) {
            // for correct padding it's necessary to set max lengths for each column
            $outputArray = array_merge([$this->header], $this->table);
            foreach ($outputArray as $row) {
                foreach ($row as $index => $item) {
                    $len = mb_strlen($item);
                    if (!isset($this->lengths[$index]) || ($this->lengths[$index] < $len)) {
                        $this->lengths[$index] = $len;
                    }
                }
            }
        }
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        $this->setLengths();
        return $this->dumpLine($this->table[$this->position], $this->colors);
    }

    public function prev(): void
    {
        $this->position--;
    }

    public function next(): void
    {
        $this->position++;
    }

    /**
     * @return int|mixed
     * @codeCoverageIgnore no access inside iterator
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        // @codeCoverageIgnoreStart
        return $this->position;
    }
    // @codeCoverageIgnoreEnd

    public function valid(): bool
    {
        return isset($this->table[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function getHeader(): string
    {
        $this->setLengths();
        if (!empty($this->header)) {
            return $this->dumpLine($this->header, $this->colorsHeader + $this->colors);
        }
        return '';
    }

    public function getSeparator(): string
    {
        $this->setLengths();
        if (!empty($this->lengths)) {
            $line = array();
            foreach ($this->lengths as $index => $length) {
                $line[$index] = str_repeat('-', $length);
            }
            return $this->dumpLine($line, $this->colorsHeader + $this->colors);
        }
        return '';
    }

    /**
     * @param iterable<int, string> $content
     * @param array<int, string> $colors
     * @return string
     */
    protected function dumpLine(iterable $content, array $colors = []): string
    {
        $line = array();
        foreach ($content as $index => $item) {
            $padded = Useful::mb_str_pad($item, $this->lengths[$index]);
            if (empty($colors[$index])) {
                $line[] = $padded;
            } else {
                $color = $colors[$index];
                $line[] = '<' . $color . '>' . $padded . '</' . $color . '>';
            }
        }
        return '| ' . implode(' | ', $line) . ' |';
    }
}

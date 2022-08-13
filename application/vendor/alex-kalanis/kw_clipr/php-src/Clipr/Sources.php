<?php

namespace kalanis\kw_clipr\Clipr;


use kalanis\kw_clipr\Interfaces\ISources;
use kalanis\kw_clipr\Output;
use kalanis\kw_input\Interfaces\IEntry;


/**
 * Class Sources
 * @package kalanis\kw_clipr\Clipr
 * @todo: idea - split dependency on sourceType - entryTypes and output to extra classes
 */
class Sources
{
    /** @var string */
    protected $sourceType = '';

    public function determineInput(bool $isWeb = false, bool $noColor = false): self
    {
        if ($noColor) {
            $this->sourceType = ISources::SOURCE_CLEAR;
        } elseif ($isWeb) {
            $this->sourceType = ISources::SOURCE_WEB;
        } else {
            switch ($this->getFamily()) {
                case 'Windows':
                    $this->sourceType = ISources::SOURCE_WINDOWS;
                    break;
                case 'BSD':
                case 'Linux':
                case 'Solaris':
                    $this->sourceType = ISources::SOURCE_POSIX;
                    break;
                default:
                    $this->sourceType = ISources::SOURCE_CLEAR;
            }
        }
        return $this;
    }

    /**
     * nicked from PHPUnit
     * @return string
     * @codeCoverageIgnore
     */
    protected function getFamily(): string
    {
        if (\defined('PHP_OS_FAMILY')) {
            return \PHP_OS_FAMILY;
        }

        if (\DIRECTORY_SEPARATOR === '\\') {
            return 'Windows';
        }

        switch (\PHP_OS) {
            case 'Darwin':
                return 'Darwin';

            case 'DragonFly':
            case 'FreeBSD':
            case 'NetBSD':
            case 'OpenBSD':
                return 'BSD';

            case 'Linux':
                return 'Linux';

            case 'SunOS':
                return 'Solaris';

            default:
                return 'Unknown';
        }
    }

    /**
     * @return string[]
     */
    public function getEntryTypes(): array
    {
        switch ($this->sourceType) {
            case ISources::SOURCE_WEB:
                return [IEntry::SOURCE_GET, IEntry::SOURCE_POST, IEntry::SOURCE_FILES];
            case ISources::SOURCE_POSIX:
            case ISources::SOURCE_WINDOWS:
            case ISources::SOURCE_CLEAR:
            default:
                return [IEntry::SOURCE_CLI, IEntry::SOURCE_FILES];
        }
    }

    public function getOutput(): Output\AOutput
    {
        switch ($this->sourceType) {
            case ISources::SOURCE_WEB:
                return new Output\Web();
            case ISources::SOURCE_POSIX:
                return new Output\Posix();
            case ISources::SOURCE_WINDOWS:
                return new Output\Windows();
            case ISources::SOURCE_CLEAR:
            default:
                return new Output\Clear();
        }
    }
}

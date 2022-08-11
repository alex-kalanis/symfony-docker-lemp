<?php

namespace kalanis\kw_clipr\Output;


/**
 * Class Windows
 * @package kalanis\kw_clipr\Output
 * Available since Windows 10
 * The base is similar to Posix, but has different stronger color coding
 * @link https://docs.microsoft.com/en-us/windows/console/console-virtual-terminal-sequences
 * @link https://www.codeproject.com/Tips/5255355/How-to-Put-Color-on-Windows-console
 * @link https://stackoverflow.com/questions/2048509/how-to-echo-with-different-colors-in-the-windows-command-line
 */
class Windows extends AOutput
{
    protected $closeSequence = "\e[0m";
    protected $formatBackSequence = "\e[%dD";
    protected $eolSequence = "\r\n";

    protected function setTags(): void
    {
        parent::setTags();
        # format style
        $this->addTranslation('normal', "\e[0m");
        $this->addTranslation('bold', "\e[1m");
        $this->addTranslation('under', "\e[4m");

        # default ones
        # foreground colors
        $this->addTranslation('black', "\e[30m");
        $this->addTranslation('red', "\e[31m");
        $this->addTranslation('green', "\e[32m");
        $this->addTranslation('brown', "\e[33m");
        $this->addTranslation('blue', "\e[34m");
        $this->addTranslation('purple', "\e[35m");
        $this->addTranslation('cyan', "\e[36m");
        $this->addTranslation('gray', "\e[37m");

        # background colors
        $this->addTranslation('blackbg', "\e[40m");
        $this->addTranslation('redbg', "\e[41m");
        $this->addTranslation('greenbg', "\e[42m");
        $this->addTranslation('brownbg', "\e[43m");
        $this->addTranslation('bluebg', "\e[44m");
        $this->addTranslation('purplebg', "\e[45m");
        $this->addTranslation('cyanbg', "\e[46m");
        $this->addTranslation('graybg', "\e[47m");

        # stronger ones
        # foreground colors
        $this->addTranslation('dgray', "\e[90m");
        $this->addTranslation('lred', "\e[91m");
        $this->addTranslation('lgreen', "\e[92m");
        $this->addTranslation('yellow', "\e[93m");
        $this->addTranslation('lblue', "\e[94m");
        $this->addTranslation('magenta', "\e[95m");
        $this->addTranslation('lcyan', "\e[96m");
        $this->addTranslation('white', "\e[97m");

        # background colors
        $this->addTranslation('dgraybg', "\e[100m");
        $this->addTranslation('lredbg', "\e[101m");
        $this->addTranslation('lgreenbg', "\e[102m");
        $this->addTranslation('yellowbg', "\e[103m");
        $this->addTranslation('lbluebg', "\e[104m");
        $this->addTranslation('magentabg', "\e[105m");
        $this->addTranslation('lcyanbg', "\e[106m");
        $this->addTranslation('whitebg', "\e[107m");
    }
}

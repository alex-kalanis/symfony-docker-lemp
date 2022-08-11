<?php

namespace kalanis\kw_clipr\Output;


/**
 * Class Posix
 * @package kalanis\kw_clipr\Output
 * @link https://www.shellhacks.com/bash-colors/
 */
class Posix extends AOutput
{
    protected $closeSequence = "\e[0m";
    protected $formatBackSequence = "\033[%dD";

    public function setTags(): void
    {
        parent::setTags();
        # format style
        $this->addTranslation('normal', "\e[0m");
        $this->addTranslation('under', "\e[4m");
        $this->addTranslation('blink', "\e[5m");

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
        $this->addTranslation('dgray', "\e[1;30m");
        $this->addTranslation('lred', "\e[1;31m");
        $this->addTranslation('lgreen', "\e[1;32m");
        $this->addTranslation('yellow', "\e[1;33m");
        $this->addTranslation('lblue', "\e[1;34m");
        $this->addTranslation('magenta', "\e[1;35m");
        $this->addTranslation('lcyan', "\e[1;36m");
        $this->addTranslation('white', "\e[1;37m");

        # background colors
        $this->addTranslation('dgraybg', "\e[1;40m");
        $this->addTranslation('lredbg', "\e[1;41m");
        $this->addTranslation('lgreenbg', "\e[1;42m");
        $this->addTranslation('yellowbg', "\e[1;43m");
        $this->addTranslation('lbluebg', "\e[1;44m");
        $this->addTranslation('magentabg', "\e[1;45m");
        $this->addTranslation('lcyanbg', "\e[1;46m");
        $this->addTranslation('whitebg', "\e[1;47m");
    }
}

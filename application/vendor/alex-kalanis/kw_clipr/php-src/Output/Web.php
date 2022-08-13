<?php

namespace kalanis\kw_clipr\Output;


class Web extends AOutput
{
    protected $closeSequence = '</span>';
    protected $eolSequence = "<br/>\r\n";

    protected function setTags(): void
    {
        parent::setTags();
        # format style
        $this->addTranslation('bold', '<span style="font-weight: bolder">');
        $this->addTranslation('under', '<span style="text-decoration: underline">');

        # default ones
        # foreground colors
        $this->addTranslation('black', '<span style="color: #000000">');
        $this->addTranslation('red', '<span style="color: #ff0000">');
        $this->addTranslation('green', '<span style="color: #008000">');
        $this->addTranslation('brown', '<span style="color: #a52a2a">');
        $this->addTranslation('blue', '<span style="color: #0000ff">');
        $this->addTranslation('purple', '<span style="color: #800080">');
        $this->addTranslation('cyan', '<span style="color: #00ffff">');
        $this->addTranslation('gray', '<span style="color: #c0c0c0">');

        # background colors
        $this->addTranslation('blackbg', '<span style="background-color: #000000">');
        $this->addTranslation('redbg', '<span style="background-color: #ff0000">');
        $this->addTranslation('greenbg', '<span style="background-color: #008000">');
        $this->addTranslation('brownbg', '<span style="background-color: #a52a2a">');
        $this->addTranslation('bluebg', '<span style="background-color: #0000ff">');
        $this->addTranslation('purplebg', '<span style="background-color: #800080">');
        $this->addTranslation('cyanbg', '<span style="background-color: #00ffff">');
        $this->addTranslation('graybg', '<span style="background-color: #c0c0c0">');

        # stronger ones
        # foreground colors
        $this->addTranslation('dgray', '<span style="color: #808080">');
        $this->addTranslation('lred', '<span style="color: #ff694d">');
        $this->addTranslation('lgreen', '<span style="color: #90ee90">');
        $this->addTranslation('yellow', '<span style="color: #ffff00">');
        $this->addTranslation('lblue', '<span style="color: #728fce">');
        $this->addTranslation('magenta', '<span style="color: #ff4edf">');
        $this->addTranslation('lcyan', '<span style="color: #e0ffff">');
        $this->addTranslation('white', '<span style="color: #ffffff">');

        # background colors
        $this->addTranslation('dgraybg', '<span style="background-color: #808080">');
        $this->addTranslation('lredbg', '<span style="background-color: #ff694d">');
        $this->addTranslation('lgreenbg', '<span style="background-color: #90ee90">');
        $this->addTranslation('yellowbg', '<span style="background-color: #ffff00">');
        $this->addTranslation('lbluebg', '<span style="background-color: #728fce">');
        $this->addTranslation('magentabg', '<span style="background-color: #ff4edf">');
        $this->addTranslation('lcyanbg', '<span style="background-color: #e0ffff">');
        $this->addTranslation('whitebg', '<span style="background-color: #ffffff">');
    }
}

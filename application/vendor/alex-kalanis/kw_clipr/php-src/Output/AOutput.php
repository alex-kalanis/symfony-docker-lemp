<?php

namespace kalanis\kw_clipr\Output;


/**
 * Class AOutput
 * @package kalanis\kw_clipr\Output
 * Abstraction to set different output codes
 */
abstract class AOutput
{
    /** @var string */
    protected $closeSequence = '';
    /** @var string */
    protected $formatBackSequence = '';
    /** @var string */
    protected $eolSequence = PHP_EOL;
    /** @var string[] */
    protected $tags = [];

    public function __construct()
    {
        $this->setTags();
    }

    protected function setTags(): void
    {
        # format style
        $this->addTranslation('normal', '');
        $this->addTranslation('bold', '');
        $this->addTranslation('under', '');
        $this->addTranslation('blink', '');

        # default ones
        # foreground colors
        $this->addTranslation('black', '');
        $this->addTranslation('red', '');
        $this->addTranslation('green', '');
        $this->addTranslation('brown', '');
        $this->addTranslation('blue', '');
        $this->addTranslation('purple', '');
        $this->addTranslation('cyan', '');
        $this->addTranslation('gray', '');

        # background colors
        $this->addTranslation('blackbg', '');
        $this->addTranslation('redbg', '');
        $this->addTranslation('greenbg', '');
        $this->addTranslation('brownbg', '');
        $this->addTranslation('bluebg', '');
        $this->addTranslation('purplebg', '');
        $this->addTranslation('cyanbg', '');
        $this->addTranslation('graybg', '');

        # stronger ones
        # foreground colors
        $this->addTranslation('dgray', '');
        $this->addTranslation('lred', '');
        $this->addTranslation('lgreen', '');
        $this->addTranslation('yellow', '');
        $this->addTranslation('lblue', '');
        $this->addTranslation('magenta', '');
        $this->addTranslation('lcyan', '');
        $this->addTranslation('white', '');

        # background colors
        $this->addTranslation('dgraybg', '');
        $this->addTranslation('lredbg', '');
        $this->addTranslation('lgreenbg', '');
        $this->addTranslation('yellowbg', '');
        $this->addTranslation('lbluebg', '');
        $this->addTranslation('magentabg', '');
        $this->addTranslation('lcyanbg', '');
        $this->addTranslation('whitebg', '');
    }

    protected function addTranslation(string $tag, string $translation): void
    {
        $this->tags[$tag] = $translation;
    }

    public function translate(string $message): string
    {
        foreach ($this->tags as $color => $translation) {
            $endSequence = empty($translation) ? '' : $this->closeSequence;
            $message = preg_replace('/\<' . $color . '\>(.*?)\<\/' . $color . '\>/i', $translation . '\1' . $endSequence, strval($message));
        }

        return strval($message);
    }

    public function getStepsBack(int $len = 1): string
    {
        return sprintf($this->formatBackSequence, $len);
    }

    public function getEol(): string
    {
        return $this->eolSequence;
    }
}

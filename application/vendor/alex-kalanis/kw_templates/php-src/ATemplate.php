<?php

namespace kalanis\kw_templates;


/**
 * Class ATemplate
 * @package kalanis\kw_templates
 * Main work with templates - process them as either string in object or blob with points of interests
 */
abstract class ATemplate
{
    /** @var string */
    protected $template = '';
    /** @var string */
    protected $defaultTemplate = '';
    /** @var Template\Item */
    protected static $item = null;
    /** @var Template\Item[] */
    protected $items = [];

    public function __construct()
    {
        $this->loadItem();
        $this->setTemplate($this->loadTemplate());
        $this->fillInputs();
    }

    /**
     * Load item as only object across the project, then copy it only when need
     */
    protected function loadItem(): void
    {
        // due init...
        // @phpstan-ignore-next-line
        if (empty(static::$item)) {
            static::$item = new Template\Item();
        }
    }

    protected function setTemplate(string $content): self
    {
        $this->defaultTemplate = $content;
        $this->reset();
        return $this;
    }

    /**
     * Here directly set or load template from external source
     * @return string
     */
    abstract protected function loadTemplate(): string;

    /**
     * Fill inputs when need - usually at the start
     */
    abstract protected function fillInputs(): void;

    protected function addInput(string $key, string $default = '', ?string $value = null): self
    {
        $copy = clone static::$item;
        $this->addItem($copy->setData($key, $default)->setValue($value));
        return $this;
    }

    protected function getItem(string $key): ?Template\Item
    {
        return isset($this->items[$key]) ? $this->items[$key] : null ;
    }

    protected function updateItem(string $key, ?string $value): self
    {
        $this->items[$key]->setValue($value);
        return $this;
    }

    protected function addItem(Template\Item $item): self
    {
        $this->items[$item->getKey()] = $item;
        return $this;
    }

    /**
     * Render template with inserted inputs
     * @return string
     */
    public function render(): string
    {
        $this->processItems();
        return $this->get();
    }

    /**
     * Process items inputs in template
     */
    protected function processItems(): void
    {
        $map = [];
        foreach ($this->items as $item) {
            $map[(string) $item->getKey()] = (string) $item->getValue();
        }
        $this->template = strtr($this->template, $map);
    }

    /**
     * replace part in template with another one
     *
     * @param string $which
     * @param string $to
     */
    public function change(string $which, string $to): void
    {
        $this->template = str_replace($which, $to, $this->template);
    }

    /**
     * get part of template
     *
     * @param int $begin where may begin
     * @param int|null $length how long it is
     * @return string
     */
    public function getSubstring(int $begin, ?int $length = null): string
    {
        return is_null($length) ? substr($this->template, $begin) : substr($this->template, $begin, $length);
    }

    /**
     * get position of sub-string
     *
     * @param string $what looking for
     * @param int $begin after...
     * @throws TemplateException
     * @return int
     */
    public function position(string $what, int $begin = 0): int
    {
        $w = $this->template;
        $w = substr($w, $begin);
        $p = strpos($w, $what);
        if (false === $p) {
            throw new TemplateException('Not found');
        }
        return $p;
    }

    /**
     * paste (include) content on position - can rewrite old one
     *
     * @param string $newString
     * @param int $fromBeing in original string
     * @param int $skip in original string
     */
    public function paste(string $newString, int $fromBeing, int $skip = 0): void
    {
        # prepare
        $fromBeing = intval(abs($fromBeing));
        $skip = intval(abs($skip));
        # run
        $leftFromBegin = substr($this->template, 0, $fromBeing);
        $leftFromEnd = (0 == $skip) ? substr($this->template, $fromBeing) : substr($this->template, $fromBeing + $skip);
        $this->template = $leftFromBegin . $newString . $leftFromEnd;
    }

    /**
     * return actual template
     * @return string
     */
    public function get(): string
    {
        return $this->template;
    }

    /**
     * reload the template
     * @return $this
     */
    public function reset(): self
    {
        $this->template = sprintf('%s', $this->defaultTemplate); // COPY!!!
        return $this;
    }
}

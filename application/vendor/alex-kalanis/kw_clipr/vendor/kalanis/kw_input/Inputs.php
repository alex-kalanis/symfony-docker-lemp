<?php

namespace kalanis\kw_input;


use Traversable;


/**
 * Class Inputs
 * @package kalanis\kw_input
 * Base class for passing info from inputs into objects
 */
class Inputs implements Interfaces\IInputs
{
    /** @var Interfaces\IEntry[] */
    protected $entries = [];
    /** @var Interfaces\ISource */
    protected $source = null;
    /** @var Parsers\Factory */
    protected $parserFactory = null;
    /** @var Loaders\Factory */
    protected $loaderFactory = null;

    public function __construct()
    {
        $this->parserFactory = new Parsers\Factory();
        $this->loaderFactory = new Loaders\Factory();
        $this->source = new Sources\Basic();
    }

    public function setSource($source = null): Interfaces\IInputs
    {
        if (!empty($source) && ($source instanceof Interfaces\ISource)) {
            $this->source = $source;
        } elseif (($this->source instanceof Sources\Basic) && is_array($source)) {
            $this->source->setCli($source);
        }
        return $this;
    }

    public function loadEntries(): void
    {
        $this->entries = array_merge(
            $this->loadInput(Interfaces\IEntry::SOURCE_EXTERNAL, $this->source->external()),
            $this->loadInput(Interfaces\IEntry::SOURCE_GET, $this->source->get()),
            $this->loadInput(Interfaces\IEntry::SOURCE_POST, $this->source->post()),
            $this->loadInput(Interfaces\IEntry::SOURCE_CLI, $this->source->cli()),
            $this->loadInput(Interfaces\IEntry::SOURCE_COOKIE, $this->source->cookie()),
            $this->loadInput(Interfaces\IEntry::SOURCE_SESSION, $this->source->session()),
            $this->loadInput(Interfaces\IEntry::SOURCE_FILES, $this->source->files()),
            $this->loadInput(Interfaces\IEntry::SOURCE_ENV, $this->source->env()),
            $this->loadInput(Interfaces\IEntry::SOURCE_SERVER, $this->source->server())
        );
    }

    /**
     * @param string $source
     * @param array<string|int, string|int|bool|string[]|int[]>|array<string|int, array<string, string>|array<string, array<string, string>>>|null $inputArray
     * @return Interfaces\IEntry[]
     */
    protected function loadInput(string $source, ?array $inputArray = null): array
    {
        if (empty($inputArray)) {
            return [];
        }
        $parser = $this->parserFactory->getLoader($source);
        $loader = $this->loaderFactory->getLoader($source);
        // @phpstan-ignore-next-line
        return $loader->loadVars($source, $parser->parseInput($inputArray));
    }

    /**
     * @param string|null $entryKey
     * @param string[] $entrySources
     * @return Traversable<string|int, Interfaces\IEntry>
     */
    public function getIn(?string $entryKey = null, array $entrySources = []): Traversable
    {
        foreach ($this->entries as $entry) {
            $allowedByKey = empty($entryKey) || ($entry->getKey() == $entryKey);
            $allowedBySource = empty($entrySources) || in_array($entry->getSource(), $entrySources);
            if ($allowedByKey && $allowedBySource) {
                yield $entry;
            }
        }
    }
}

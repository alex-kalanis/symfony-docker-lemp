<?php

namespace kalanis\kw_clipr;


use kalanis\kw_input\Interfaces\IFiltered;


/**
 * Class Clipr
 * @package kalanis\kw_clipr
 * Main class which runs the whole task system
 */
class Clipr
{
    /** @var Interfaces\ILoader */
    protected $loader = null;
    /** @var IFiltered */
    protected $variables = null;
    /** @var Clipr\Sources */
    protected $sources = null;

    public function __construct(Interfaces\ILoader $loader, Clipr\Sources $sources, IFiltered $variables)
    {
        $this->loader = $loader;
        $this->sources = $sources;
        $this->variables = $variables;
    }

    /**
     * @param string $namespace
     * @param string $path
     * @throws CliprException
     * @return $this
     */
    public function addPath(string $namespace, string $path): self
    {
        Clipr\Paths::getInstance()->addPath($namespace, $path);
        return $this;
    }

    /**
     * @throws CliprException
     */
    public function run(): void
    {
        // for parsing default params it's necessary to load another task
        $dummy = new Tasks\DummyTask();
        $dummy->initTask(new Output\Clear(), $this->variables, $this->loader);
        $this->sources->determineInput((bool) $dummy->webOutput, (bool) $dummy->noColor);

        // now we know necessary input data, so we can initialize real task
        $inputs = $this->variables->getInArray(null, $this->sources->getEntryTypes());
        $taskName = Clipr\Useful::getNthParam($inputs) ?? Interfaces\ILoader::DEFAULT_TASK;
        $task = $this->loader->getTask($taskName);
        if (!$task) {
            throw new CliprException(sprintf('Unknown task *%s* - check name, interface or your config paths.', $taskName));
        }
        $task->initTask($this->sources->getOutput(), $this->variables, $this->loader);

        if (Interfaces\ISources::OUTPUT_STD != $task->outputFile) {
            ob_start();
        }

        if (false === $task->noHeaders) {
            $task->writeHeader();
        }

        $task->process();

        if (false === $task->noHeaders) {
            $task->writeFooter();
        }

        if (Interfaces\ISources::OUTPUT_STD != $task->outputFile) {
            file_put_contents($task->outputFile, ob_get_clean(), (false === $task->noAppend ? FILE_APPEND : 0));
        }
    }
}

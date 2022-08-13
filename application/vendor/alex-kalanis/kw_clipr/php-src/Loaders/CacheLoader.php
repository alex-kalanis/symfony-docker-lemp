<?php

namespace kalanis\kw_clipr\Loaders;


use kalanis\kw_clipr\Clipr\Useful;
use kalanis\kw_clipr\Interfaces\ILoader;
use kalanis\kw_clipr\Tasks\ATask;


/**
 * Class CacheLoader
 * @package kalanis\kw_clipr\Tasks
 * Cache classes got by child loader
 */
class CacheLoader implements ILoader
{
    /** @var ILoader */
    protected $loader = null;
    /** @var ATask[] */
    protected $loadedClasses = [];

    public static function init(ILoader $loader): self
    {
        return new static($loader);
    }

    final public function __construct(ILoader $loader)
    {
        $this->loader = $loader;
    }

    public function getTask(string $classFromParam): ?ATask
    {
        $classPath = Useful::sanitizeClass($classFromParam);
        if (empty($this->loadedClasses[$classPath])) {
            $availableTask = $this->loader->getTask($classFromParam);
            if (!$availableTask) {
                return null;
            }
            $this->loadedClasses[$classPath] = $availableTask;
        }
        return $this->loadedClasses[$classPath];
    }
}

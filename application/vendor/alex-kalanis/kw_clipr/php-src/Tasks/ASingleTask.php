<?php

namespace kalanis\kw_clipr\Tasks;


use kalanis\kw_clipr\CliprException;
use kalanis\kw_locks\Interfaces\ILock;
use kalanis\kw_locks\Interfaces\IPassedKey;
use kalanis\kw_locks\LockException;
use kalanis\kw_locks\Methods\PidLock;


/**
 * Class ASingleTask
 * @package kalanis\kw_clipr\Tasks
 * @property bool $singleInstance
 */
abstract class ASingleTask extends ATask
{
    /** @var ILock */
    protected $lock = null;

    /**
     * @param ILock|null $lock
     * @throws LockException
     */
    public function __construct(?ILock $lock = null)
    {
        $this->lock = $lock ?? $this->getPresetLock();
        if ($this->lock instanceof IPassedKey) {
            $this->lock->setKey(str_replace('/', ':', get_class($this)) . ILock::LOCK_FILE);
        } elseif (method_exists($this->lock, 'setClass')) {
            $this->lock->/** @scrutinizer ignore-call */setClass($this);
        }
        // lock target must go via lock's constructor
        // when it comes via IStorage (StorageLock), it's possible to connect it into Redis or Memcache and then that path might not be necessary
    }

    /**
     * @throws LockException
     * @return ILock
     */
    protected function getPresetLock(): ILock
    {
        return new PidLock($this->getTempPath());
    }

    protected function getTempPath(): string
    {
        return '/tmp';
    }

    /**
     * @throws CliprException
     */
    protected function startup(): void
    {
        parent::startup();
        $this->params->addParam('singleInstance', 'single-instance', null, false, 's', 'Call only single instance');

        $this->checkSingleInstance();
    }

    /**
     * @throws CliprException
     */
    protected function checkSingleInstance(): void
    {
        try {
            if ($this->isSingleInstance() && $this->isRunLocked()) {
                // check if exists another instance
                throw new SingleTaskException('One script instance is already running!');
                // create own lock file
            }
        } catch (LockException $ex) {
            throw new SingleTaskException('Locked by another user. Cannot unlock here.', 0, $ex);
        }
    }

    protected function isSingleInstance(): bool
    {
        return (true === $this->singleInstance);
    }

    /**
     * @throws LockException
     * @return bool
     */
    protected function isRunLocked(): bool
    {
        try {
            if (!$this->lock->has()) {
                $this->lock->create();
                return false;
            }
            return true;
        } catch (LockException $ex) {
            $this->writeLn('Removing stale lock file.');
            $this->lock->delete(true);
            return false;
        }
    }
}

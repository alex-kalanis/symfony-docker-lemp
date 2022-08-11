<?php

namespace kalanis\kw_forms\Cache;


use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\StorageException;


trait TStorage
{
    /** @var Storage|null */
    protected $storage = null;

    public function setStorage(?IStorage $storage = null): self
    {
        $this->storage = new Storage($storage);
        $this->storage->setAlias(strval($this->getAlias()));
        return $this;
    }

    /**
     * Check if data is set inside storage
     * @return bool
     */
    public function isStored(): bool
    {
        return $this->storage ? $this->storage->isStored() : false ;
    }

    /**
     * Delete form data in storage
     * @throws StorageException
     */
    public function deleteStored(): void
    {
        if ($this->storage) {
            $this->storage->delete();
        }
    }

    abstract public function getAlias(): ?string;
}

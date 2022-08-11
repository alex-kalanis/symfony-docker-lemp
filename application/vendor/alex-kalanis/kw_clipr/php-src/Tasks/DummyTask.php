<?php

namespace kalanis\kw_clipr\Tasks;


/**
 * Class DummyTask
 * @package kalanis\kw_clipr\Tasks
 */
class DummyTask extends ATask
{
    public function desc(): string
    {
        return 'Just dummy task for processing info from params';
    }

    public function process(): void
    {
    }
}

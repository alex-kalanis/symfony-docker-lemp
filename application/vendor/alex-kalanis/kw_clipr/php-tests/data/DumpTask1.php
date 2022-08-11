<?php

namespace data;


use kalanis\kw_clipr\Tasks\ATask;


class DumpTask1 extends ATask
{
    public function process(): void
    {
        // nothing
    }

    public function desc(): string
    {
        return 'testing task 1';
    }
}

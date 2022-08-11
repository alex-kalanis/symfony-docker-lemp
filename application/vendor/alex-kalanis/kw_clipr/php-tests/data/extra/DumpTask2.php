<?php

namespace data\extra;


use kalanis\kw_clipr\Tasks\ATask;


class DumpTask2 extends ATask
{
    public function process(): void
    {
        // nothing
    }

    public function desc(): string
    {
        return 'testing task 2';
    }
}

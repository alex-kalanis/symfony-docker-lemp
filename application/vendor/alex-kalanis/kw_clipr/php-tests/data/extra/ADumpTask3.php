<?php

namespace data\extra;


use kalanis\kw_clipr\Tasks\ATask;


abstract class ADumpTask3 extends ATask
{
    public function desc(): string
    {
        return 'testing task 3 - do not show, it is abstract';
    }
}

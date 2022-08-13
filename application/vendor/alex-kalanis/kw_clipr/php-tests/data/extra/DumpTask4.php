<?php

namespace data\extra;


use kalanis\kw_clipr\Tasks\ATask;


abstract class ADumpTask4 extends ATask
{
    public function desc(): string
    {
        return 'testing task 4 - do not show, name is different from file';
    }
}

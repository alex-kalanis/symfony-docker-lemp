<?php

namespace App\Tasks\Database;


/**
 * Class Rollback
 * @package App\Tasks\Database
 */
class Rollback extends APhinx
{
    public function desc(): string
    {
        return 'Rollback changes in project via internal Phinx';
    }

    public function action(): string
    {
        return 'rollback';
    }
}

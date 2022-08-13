<?php

namespace App\Tasks\Database;


/**
 * Class Migrate
 * @package App\Tasks\Database
 */
class Migrate extends APhinx
{
    public function desc(): string
    {
        return 'Migrate changes in project via internal Phinx';
    }

    public function action(): string
    {
        return 'migrate';
    }
}

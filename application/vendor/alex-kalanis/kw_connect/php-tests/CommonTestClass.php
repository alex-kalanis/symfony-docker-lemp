<?php

use PHPUnit\Framework\TestCase;


/**
 * Class CommonTestClass
 * The structure for mocking and configuration seems so complicated, but it's necessary to let it be totally idiot-proof
 */
class CommonTestClass extends TestCase
{
    protected function sourceRows(): array
    {
        return [
            ['abc' => 1, 'def' => 'dave', 'ghi' => 'any', 'jkl' => 123, 'mno' => false, 'pqr' => true],
            ['abc' => 2, 'def' => 'john', 'ghi' => 'one', 'jkl' => 456, 'mno' => false, 'pqr' => false],
            ['abc' => 3, 'def' => 'emil', 'ghi' => 'any', 'jkl' => 789, 'mno' => true, 'pqr' => true],
            ['abc' => 4, 'def' => 'josh', 'ghi' => 'any', 'jkl' => 101, 'mno' => true, 'pqr' => false],
            ['abc' => 5, 'def' => 'ewan', 'ghi' => 'one', 'jkl' => 112, 'mno' => false, 'pqr' => false],
            ['abc' => 6, 'def' => 'kami', 'ghi' => 'any', 'jkl' => 131, 'mno' => true, 'pqr' => false],
            ['abc' => 7, 'def' => 'chuck', 'ghi' => 'one', 'jkl' => 415, 'mno' => false, 'pqr' => true],
            ['abc' => 8, 'def' => 'phil', 'ghi' => 'any', 'jkl' => 161, 'mno' => true, 'pqr' => true],
            ['abc' => 9, 'def' => 'wayne', 'ghi' => 'any', 'jkl' => 718, 'mno' => false, 'pqr' => false],
        ];
    }
}

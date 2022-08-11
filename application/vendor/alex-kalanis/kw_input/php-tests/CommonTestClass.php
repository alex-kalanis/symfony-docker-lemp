<?php

use PHPUnit\Framework\TestCase;


class CommonTestClass extends TestCase
{
    protected function entryDataset(): array
    {
        return [
            'foo' => 'val1',
            'bar' => ['bal1', 'bal2'],
            'baz' => true,
            'aff' => 42,
        ];
    }

    protected function strangeEntryDataset(): array
    {
        return [
            'foo  ' => ' val1 ',
            'ba' . chr(0) . 'r' => ["<script>alert('XSS!!!')</script>", 'bal2'],
            'b<a>z' => false,
            'a**ff' => '<?php echo "ded!";',
        ];
    }

    protected function fileDataset(): array
    {
        return [
            'files' => [ // simple upload
                'name' => 'facepalm.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php3zU3t5',
                'error' => UPLOAD_ERR_OK,
                'size' => 591387,
            ],
            'download' => [ // multiple upload
                'name' => [
                    'file1' => 'MyFile.txt',
                    'file2' => 'MyFile.jpg',
                ],
                'type' => [
                    'file1' => 'text/plain',
                    'file2' => 'image/jpeg',
                ],
                'tmp_name' => [
                    'file1' => '/tmp/php/phpgj46fg',
                    'file2' => '/tmp/php/php7s4ag4',
                ],
                'error' => [
                    'file1' => UPLOAD_ERR_CANT_WRITE,
                    'file2' => UPLOAD_ERR_PARTIAL,
                ],
                'size' => [
                    'file1' => 816,
                    'file2' => 3075,
                ],
            ],
        ];
    }

    protected function strangeFileDataset(): array
    {
        return [
            'fi' . chr(0) . 'les' => [ // simple upload
                'name' => 'face' . chr(0) . 'palm.jpg',
                'type' => 'image<?= \'/\'; ?>jpeg',
                'tmp_name' => '/tmp/php3zU3t5',
                'error' => UPLOAD_ERR_OK,
                'size' => '591387',
            ],
            'download' => [ // multiple upload
                'name' => [
                    'file1' => 'C:\System\MyFile.txt',
                    'file2' => 'A:\MyFile.jpg',
                ],
                'type' => [
                    'file1' => 'text/plain',
                    'file2' => 'image/jpeg',
                ],
                'tmp_name' => [
                    'file1' => '/tmp/php/phpgj46fg',
                    'file2' => '/tmp/php/php7s4ag4',
                ],
                'error' => [
                    'file1' => UPLOAD_ERR_CANT_WRITE,
                    'file2' => UPLOAD_ERR_PARTIAL,
                ],
                'size' => [
                    'file1' => 816,
                    'file2' => 6874,
                ],
            ],
        ];
    }

    protected function cliDataset(): array
    {
        return [
            '--testing=foo',
            '--bar=baz',
            '--bar=eek',
            '--mko=',
            '--der',
            '--file1=./data/tester.gif',
            '--file2=data/testing.1.txt',
            '--file3=./data/testing.2.txt',
            '-abc',
            'known',
            'what',
        ];
    }

    protected function strangeCliDataset(): array
    {
        return [
            '--tes' . chr(0) . 'ting=f<o>o',
            '---bar=b**a**z',
            '-a-*c',
        ];
    }
}

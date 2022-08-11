<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_address_handler\Headers;


class HeaderTest extends CommonTestClass
{
    /**
     * @param int $setCode
     * @param int $defaultCode
     * @param string $expected
     * @dataProvider headerProvider
     */
    public function testBasic(int $setCode, int $defaultCode, string $expected): void
    {
        $this->assertEquals($expected, Headers::codeToHeader($setCode, $defaultCode));
    }

    public function headerProvider(): array
    {
        return [
            [502, 200, '502 Bad Gateway'],
            [501, 900, '501 Not Implemented'],
            [900, 502, '502 Bad Gateway'],
            [900, 905, '500 Internal Server Error'],
        ];
    }
}

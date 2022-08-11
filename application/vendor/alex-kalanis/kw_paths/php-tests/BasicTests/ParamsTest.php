<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Params;


class ParamsTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $params = new Params\Arrays();
        $params->setData(['abc'=>'def','ghi'=>'jkl','mno'=>'pqr',]);
        $this->assertEquals(['abc'=>'def','ghi'=>'jkl','mno'=>'pqr',], $params->process()->getParams());
    }

    public function testArrayAccess(): void
    {
        $data = new \ArrayObject([
            'abc'=>'/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr',
            'ghi'=>'/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1',
            'mno'=>'/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr',
        ]);
        $params = new Params\Request\ArrayAccess();
        $params->set($data);
        $this->assertEquals([
            'staticalPath' => null, 'virtualPrefix' => null, 'path' => '',
        ], $params->process()->getParams());
        $params->set($data, 'ghi');
        $this->assertEquals([
            'staticalPath' => '/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/',
            'virtualPrefix' => null, 'abc'=>'def', 'ghi' => ['jkl', 'mno'],
            'pqr' => '', 'vars' => '1'
        ], $params->process()->getParams());
    }

    /**
     * @param string $uri
     * @param string|null $virtualDir
     * @param string $key
     * @param bool $wantExistence
     * @param string|null $value
     * @dataProvider requestProvider
     */
    public function testRequest(string $uri, ?string $virtualDir, string $key, bool $wantExistence, ?string $value)
    {
        $params = new Params\Request();
        $result = $params->setData($uri, $virtualDir)->process()->getParams();
        $this->assertEquals($wantExistence, isset($result[$key]));
        if ($wantExistence) {
            $this->assertEquals($value, $result[$key]);
        }
    }

    public function requestProvider(): array
    {
        return [
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'abc', true, 'def'],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'lang', false, null],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'staticalPath', true, '/Sources/Request.php'],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'path', false, null],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '', 'staticalPath', false, null],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '', 'path', true, '/Sources/Request.php'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'lang', false, null],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', null, 'abc', true, 'def'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'staticalPath', true, '/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'path', false, null],

            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', '', 'staticalPath', false, null],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', '', 'path', true, 'definite/unknown/'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'abc', true, 'def'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'lang', true, 'rrr'],
            ['/web/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'pqr', true, ''],
            ['/web/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'path', true, 'definite/unknown/'],
            ['/web/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr', 'web/', 'module', true, 'stgs'],
            ['/web/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'system/', 'staticalPath', true, '/web/m:stgs/u:gnfnj/g:/definite/unknown/'],
            ['/web/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'system/', 'path', false, null],
            ['/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '/', 'module', true, 'stgs'],

            ['/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '/', 'staticalPath', true, ''],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '/', 'staticalPath', true, ''],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '/', 'path', true, 'definite/unknown/'],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '', 'staticalPath', false, null],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '', 'path', true, '/definite/unknown/'],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', null, 'staticalPath', true, '/definite/unknown/'],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', null, 'path', false, null],
        ];
    }
}

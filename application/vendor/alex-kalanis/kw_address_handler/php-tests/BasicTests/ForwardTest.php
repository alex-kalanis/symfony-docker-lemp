<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_address_handler\Forward;


class ForwardTest extends CommonTestClass
{
    /**
     * @param string $basicLink
     * @param bool $has
     * @param string $forwardLink
     * @param string $fullLink
     * @dataProvider forwardProvider
     */
    public function testBasic(string $basicLink, bool $has, string $forwardLink, string $fullLink): void
    {
        $fwd = new Forward();
        $fwd->setLink($basicLink);
        $this->assertEquals($basicLink, $fwd->getLink());
        $this->assertEquals($has, $fwd->has());
        $fwd->setForward($forwardLink);
        $this->assertEquals($forwardLink, $fwd->get());
        $this->assertEquals($fullLink, $fwd->getLink());
    }

    public function forwardProvider(): array
    {
        return [
            ['/abc/def/?ghi=jkl&mno=pqr', false, '/njibhu/', '/abc/def/?ghi=jkl&mno=pqr&fwd=%2Fnjibhu%2F'],
            ['/abc/def/?ghi=jkl&mno=pqr&fwd=%2Fdstx%2F', true, '/vgzcft/', '/abc/def/?ghi=jkl&mno=pqr&fwd=%2Fvgzcft%2F'],
            ['/abc/def/?ghi=jkl&mno=pqr', false, '/xdryse/', '/abc/def/?ghi=jkl&mno=pqr&fwd=%2Fxdryse%2F'],
            ['/abc/def/?ghi=jkl&mno=pqr&fwd=%2Fdstx%2F', true, '/cdevfr/', '/abc/def/?ghi=jkl&mno=pqr&fwd=%2Fcdevfr%2F'],
        ];
    }
}

<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Storage\Format;
use kalanis\kw_storage\Storage\Target;
use kalanis\kw_storage\StorageException;


class FormatsTest extends CommonTestClass
{
    /**
     * @throws StorageException
     */
    public function testInit(): void
    {
        $factory = new Format\Factory();
        $this->assertInstanceOf('\kalanis\kw_storage\Storage\Format\Format', $factory->getFormat(new Target\Volume()));
    }

    /**
     * @throws StorageException
     */
    public function testRaw(): void
    {
        $format = new Format\Raw();
        $this->assertEquals('aaaaaaa', $format->decode($format->encode('aaaaaaa')));
        $this->assertEquals('ear/a4vw-z.7v2!3#z', $format->decode($format->encode('ear/a4vw-z.7v2!3#z')));
        $cont = $this->complicatedStructure(true);
        $this->assertEquals($cont, $format->decode($format->encode($cont)));
    }

    /**
     * @throws StorageException
     */
    public function testSerialized(): void
    {
        $format = new Format\Serialized();
        $this->assertEquals('aaaaaaa', $format->decode($format->encode('aaaaaaa')));
        $this->assertEquals('ear/a4vw-z.7v2!3#z', $format->decode($format->encode('ear/a4vw-z.7v2!3#z')));
        $cont = $this->complicatedStructure(true);
        $this->assertEquals($cont, $format->decode($format->encode($cont)));
    }

    /**
     * @throws StorageException
     */
    public function testFormat(): void
    {
        $format = new Format\Format();
        $this->assertEquals('aaaaaaa', $format->decode($format->encode('aaaaaaa')));
        $this->assertEquals('ear/a4vw-z.7v2!3#z', $format->decode($format->encode('ear/a4vw-z.7v2!3#z')));
        $this->assertEquals(false, $format->decode($format->encode(false)));
        $this->assertEquals(1.75, $format->decode($format->encode(1.75)));
        $cont = $this->complicatedStructure(false);
        $this->assertEquals($cont, $format->decode($format->encode($cont)));
    }

    protected function complicatedStructure(bool $withObject = false)
    {
        $stdCl = new \stdClass();
        $stdCl->any = 'sdgghsdfh6976h4sd';
        $stdCl->sdg = 43.5424;
        $stdCl->ddd = new \stdClass();
        $stdCl->ddd->df56sh43 = 4351254;
        return ['6g8a7' => 'dfh4dg364sd6g', 'hzsdfgh' => 35.4534, 'sfkg' => false] + ($withObject ? ['hdhg' => $stdCl] : []);
    }
}

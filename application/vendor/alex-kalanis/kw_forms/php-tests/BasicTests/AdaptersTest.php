<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_forms\Adapters;
use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_input\Filtered\SimpleArrays;
use kalanis\kw_input\Interfaces\IEntry;


class AdaptersTest extends CommonTestClass
{
    /**
     * @param Adapters\AAdapter $adapter
     * @param string $inputType
     * @param bool $canCount
     * @param bool $canThrough
     * @param bool $canStep
     * @param bool $canSet
     * @throws FormsException
     * @dataProvider adapterProvider
     */
    public function testAdapter(Adapters\AAdapter $adapter, string $inputType, bool $canCount, bool $canThrough, bool $canStep, bool $canSet): void
    {
        $adapter->loadEntries($inputType);
        $this->assertNotEmpty($adapter->getSource());
        if ($canCount) {
            $this->assertEquals(9, $adapter->count());
            $this->assertEquals('aff', $adapter->offsetGet('foo'));
        }
        if ($canThrough) {
            foreach ($adapter as $key => $item) {
                $this->assertNotEmpty($key);
                $this->assertNotEmpty($item);
            }
        }
        if ($canStep) {
            $adapter->rewind();
            $adapter->next();
            $this->assertNotEmpty($adapter->getKey());
            $this->assertNotEmpty($adapter->getValue());
        }

        if ($canSet) {
            $this->assertFalse($adapter->offsetExists('fee'));
            $adapter->offsetSet('fee','nnn');
            $this->assertTrue($adapter->offsetExists('fee'));
            $adapter->offsetUnset('fee');
            $this->assertFalse($adapter->offsetExists('fee'));
        }
    }

    public function adapterProvider(): array
    {
        $entry = new \kalanis\kw_input\Entries\Entry();
        $entry->setEntry(\kalanis\kw_input\Interfaces\IEntry::SOURCE_EXTERNAL, 'xggxgx', 'lkjhdf');
        $_GET = [
            'foo' => 'aff',
            'bar' => 'poa',
            'baz' => 'cdd',
            'sgg' => 'arr',
            'sd#,\'srs' => 'ggsd<$=',
            'dsr.!>sd' => 'zfd?-"',
            'dg-[]' => 'dc^&#~\\€`~°',
            'dg[]' => '<?php =!@#dc^&#~',
            'xggxgx' => $entry,
        ];
        return [
            [new \Adapter(), '', true, true, true, true ],
            [new Adapters\ArrayAdapter($_GET), IEntry::SOURCE_GET, true, true, true, true ],
            [new Adapters\VarsAdapter(), IEntry::SOURCE_GET, true, false, true, true ],
            [new Adapters\VarsAdapter(), IEntry::SOURCE_POST, false, false, false, true ],
            [new Adapters\SessionAdapter(), '', false, false, false, true ],
            [new \Files(), '', false, false, false, false ],
        ];
    }

    /**
     * Because it's necessary to test constructor
     * @throws FormsException
     */
    public function testArrayAdapter(): void
    {
        $this->testAdapter(
            new Adapters\ArrayAdapter([
                'foo' => 'aff',
                'bar' => 'poa',
                'baz' => 'cdd',
                'sgg' => 'arr',
                'sd#,\'srs' => 'ggsd<$=',
                'dsr.!>sd' => 'zfd?-"',
                'dg-[]' => 'dc^&#~\\€`~°',
                'dg[]' => '<?php =!@#dc^&#~',
                'xggxgx' => 'free',
            ]),
            IEntry::SOURCE_GET,
            true,
            true,
            true,
            true
        );
    }

    /**
     * @throws FormsException
     */
    public function testVarsAdapterDie(): void
    {
        $adapter = new Adapters\VarsAdapter();
        $this->expectException(FormsException::class);
        $adapter->loadEntries('unknown_one');
    }

    /**
     * Because it's necessary to test constructor
     * @throws FormsException
     */
    public function testInputVarsAdapter(): void
    {
        $this->testAdapter(
            new Adapters\InputVarsAdapter(new SimpleArrays([
                'foo' => 'aff',
                'bar' => 'poa',
                'baz' => 'cdd',
                'sgg' => 'arr',
                'sd#,\'srs' => 'ggsd<$=',
                'dsr.!>sd' => 'zfd?-"',
                'dg-[]' => 'dc^&#~\\€`~°',
                'dg[]' => '<?php =!@#dc^&#~',
                'xggxgx' => 'free',
            ])),
            IEntry::SOURCE_CLI,
            true,
            true,
            true,
            true
        );
    }

    /**
     * @throws FormsException
     */
    public function testInputVarsAdapterPassInputs(): void
    {
        $adapter = new Adapters\InputVarsAdapter(new SimpleArrays([
            'foo' => 'aff',
        ], IEntry::SOURCE_CLI));
        // input type there does not matter, because simple arrays have no information about source - there is no source
        $adapter->loadEntries(IEntry::SOURCE_CLI);
        $this->assertEquals(1, $adapter->count());
        $adapter->loadEntries(IEntry::SOURCE_GET);
        $this->assertEquals(1, $adapter->count());
        $adapter->loadEntries(IEntry::SOURCE_POST);
        $this->assertEquals(1, $adapter->count());
    }

    /**
     * @throws FormsException
     */
    public function testInputVarsAdapterDieBadInput(): void
    {
        $adapter = new Adapters\InputVarsAdapter(new SimpleArrays([
            'foo' => 'aff',
        ]));
        // session is not available as data source
        $this->expectException(FormsException::class);
        $adapter->loadEntries(IEntry::SOURCE_SESSION);
    }

    /**
     * @throws FormsException
     */
    public function testInputVarsAdapterDieOutOfRange(): void
    {
        $adapter = new Adapters\InputVarsAdapter(new SimpleArrays([
            'foo' => 'aff',
        ]));
        $adapter->rewind();
        $adapter->next();

        $this->expectException(FormsException::class);
        $adapter->current();
    }

    /**
     * @throws FormsException
     */
    public function testAdapterFile(): void
    {
        $adapter = new \Files();
        $adapter->loadEntries('');
        $adapter->rewind();
        $adapter->next();
        $this->assertNotEmpty($adapter->getKey());
        $this->assertNotEmpty($adapter->getValue());
        $this->assertNotEmpty($adapter->current()->getMimeType());
        $this->assertNotEmpty($adapter->current()->getTempName());
        $this->assertNotEmpty($adapter->current()->getError());
        $this->assertNotEmpty($adapter->current()->getSize());
        $this->assertEquals(IEntry::SOURCE_FILES, $adapter->current()->getSource());
        $adapter->next();
        $adapter->next();
        $adapter->next();
        $adapter->next();
        $this->expectException(FormsException::class);
        $adapter->getValue(); // not exists
    }

    /**
     * @throws FormsException
     */
    public function testInputFilesAdapterProcess(): void
    {
        $adapter = new Adapters\InputFilesAdapter(new SimpleArrays([
            'foo' => 'aff',
        ], IEntry::SOURCE_FILES));
        // input type there does not matter, because simple arrays have no information about source - there is no source
        $adapter->loadEntries(IEntry::SOURCE_CLI);
        $this->assertEquals(1, $adapter->count());

        $adapter->rewind();
        $adapter->current();
        $adapter->next();

        $this->expectException(FormsException::class);
        $adapter->current();
    }
}

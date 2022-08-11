<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Exceptions\EntryException;
use kalanis\kw_rules\Interfaces\IRules;


class FilesTest extends CommonTestClass
{
    public function testFile(): void
    {
        $input = new Controls\File();
        $input->set('myown', 'original');
        $this->assertEquals('<input type="file" id="myown" name="myown" />', $input->renderInput());
        $input->setValue('jhgfd');
        $this->assertEquals('<input type="file" id="myown" name="myown" />', $input->renderInput());
    }

    public function testFiles(): void
    {
        $input = new Controls\Files();
        $input->set('myown', ['one', 'two'], 'Upload files');
        $this->assertEquals(
  '<label for="myown_0">one</label> <input type="file" id="myown_0" name="myown[]" /> ' . PHP_EOL
. '<label for="myown_1">two</label> <input type="file" id="myown_1" name="myown[]" /> ' . PHP_EOL, $input->renderInput());
    }

    public function testFiles2(): void
    {
        $input = new Controls\Files();
        $input->set('myown', ['foo' => 'one', 'bar' => 'two'], 'Upload files');
        $this->assertEquals(
  '<label for="myown_0">one</label> <input type="file" id="myown_0" name="myown[foo]" /> ' . PHP_EOL
. '<label for="myown_1">two</label> <input type="file" id="myown_1" name="myown[bar]" /> ' . PHP_EOL, $input->renderInput());
    }

    public function testFiles3(): void
    {
        $adapter = new \Files();
        $adapter->loadEntries('');
        $adapter->rewind();

        $input = new Controls\Files();
        $input->set('download', ['file1' => 'one', 'file2' => 'two'], 'Upload files');
        $input->setValues(iterator_to_array($adapter));

        $this->assertNotEmpty($input->getValues());
        $this->assertEquals(
  '<label for="download_0">one</label> <input type="file" id="download_0" name="download[file1]" /> ' . PHP_EOL
. '<label for="download_1">two</label> <input type="file" id="download_1" name="download[file2]" /> ' . PHP_EOL, $input->renderInput());
    }

    public function testFiles4(): void
    {
        $adapter = new \Files();
        $adapter->loadEntries('');
        $adapter->rewind();

        $input = new Controls\Files();
        $input->set('numbered', ['one', 'two'], 'Upload files');
        $input->setValues(iterator_to_array($adapter));

        $this->assertEquals(
  '<label for="numbered_0">one</label> <input type="file" id="numbered_0" name="numbered[]" /> ' . PHP_EOL
. '<label for="numbered_1">two</label> <input type="file" id="numbered_1" name="numbered[]" /> ' . PHP_EOL, $input->renderInput());
    }

    public function testFileUnknown(): void
    {
        $input = new Controls\File();
        $input->set('files', 'not_posted');
        $input->addRule(IRules::FILE_EXISTS, 'file must exist');
        $this->expectException(EntryException::class);
        $input->getFile();
    }

    public function testFileInput(): void
    {
        $adapter = new \Files();
        $adapter->loadEntries('');
        $adapter->rewind();

        $input = new Controls\File();
        $input->set('files', 'posted');
        $input->setValue($adapter->current());

        $this->assertEquals('<input type="file" id="files" name="files" />', $input->renderInput());
        $this->assertEquals('facepalm.jpg', $input->getValue());
        $this->assertEquals('image/jpeg', $input->getMimeType());
        $this->assertEquals('/tmp/php3zU3t5', $input->getTempName());
        $this->assertEquals(0, $input->getError());
        $this->assertEquals(591387, $input->getSize());
        $this->assertNotEmpty($input->getFile());
    }
}

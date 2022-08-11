<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_forms\Form;
use kalanis\kw_rules\Interfaces\IRules;


class FormTest extends CommonTestClass
{
    public function testFormInit(): void
    {
        $files = new \Files();
        $files->loadEntries('');
        $inputs = new \Adapter();

        $form = new Form('test');
        $form->setInputs($inputs, $files);

        $this->assertInstanceOf('\kalanis\kw_forms\Controls\Factory', $form->getControlFactory());
        $form->addControlDefaultKey($form->getControlFactory()->getControl('html')->setEntry('html', 'testing input'));
        $this->assertEmpty($form->getControl('baz'));
    }

    public function testStorage(): void
    {
        $files = new \Files();
        $files->loadEntries('');

        $form = new Form('test');
        $form->setInputs(new \Adapter(), $files);
        $form->setStorage(new \StorageMock());
        $form->addText('foo', 'first');
        $form->addText('bar', 'second');
        $form->addText('baz', 'third');
        $form->addFiles('other', 'file');

        $this->assertEmpty($form->getValue('foo'));
        $this->assertEmpty($form->getValue('bar'));
        $this->assertEmpty($form->getValue('unknown'));

        $form->setSentValues();
        $form->store();
        $form->loadStored();

        $this->assertEquals('aff', $form->getValue('foo'));
        $this->assertEquals('poa', $form->getValue('bar'));

        $form->setValue('other', reset($files));
        $form->setValue('baz', 'here');
    }

    public function testLabels(): void
    {
        $form = new Form('test');
        $form->setInputs(new \Adapter());
        $form->addText('foo', 'first');
        $form->addText('bar', 'second');
        $form->addText('baz', 'third');

        $form->setLabels([
            'foo' => 'uno',
            'bar' => 'duo',
        ]);

        $labels = $form->getLabels();
        $this->assertNotEmpty($labels['foo']);
        $this->assertEquals('uno', $labels['foo']);
        $this->assertNotEmpty($labels['bar']);
        $this->assertEquals('duo', $labels['bar']);

        $form->setLabel('troi', 'baz');
        $this->assertEquals('troi', $form->getLabel('baz'));
        $this->assertEmpty($form->getLabel('what'));

        $form->setLabel('our form');
        $this->assertEquals('our form', $form->getLabel());
    }

    public function testProcessing(): void
    {
        $form = new Form('test');
        $form->addHidden('dez', 'shade');
        $form->addText('foo', 'first')->addRule(IRules::IS_FILLED, 'content filled');
        $form->addText('bar', 'second');
        $last = $form->addText('baz', 'third');
        $this->assertFalse($form->process('baz'));
        $this->assertEmpty($form->renderControlErrors('baz'));

        $form->setInputs(new \Adapter());
        $this->assertFalse($form->process());
        $this->assertEmpty($form->renderErrors());

        $form->addSubmit('sgg', 'ijn');
        $form->setInputs(new \Adapter());
        $this->assertTrue($form->process());
        $this->assertTrue($form->process('baz'));

        $last->addRule(IRules::IS_NUMERIC, 'must be a number');
        $this->assertFalse($form->process());
        $this->assertEquals('must be a number', $form->renderControlErrors('baz'));

        $this->assertNotEmpty($form->render());
        $this->assertNotEmpty($form->renderStart());
        $this->assertNotEmpty($form->renderEnd());
    }

    public function testLayout(): void
    {
        $form = new Form('test');
        $form->setInputs(new \Adapter());
        $form->addText('foo', 'first');
        $form->addText('bar', 'second');
        $form->setLayout('table');
        $form->setLayout('inlineTable');
        $this->assertNotEmpty($form->render());
    }
}

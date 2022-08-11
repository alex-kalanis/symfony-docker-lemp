<?php

namespace ControlTests;


use CommonTestClass;
use kalanis\kw_forms\Controls;
use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_forms\Exceptions\RenderException;
use kalanis\kw_forms\Form;
use kalanis\kw_rules\Interfaces\IRules;
use kalanis\kw_rules\Validate;


class TreeTest extends CommonTestClass
{
    /**
     * @throws RenderException
     */
    public function testSimpleAny(): void
    {
        $input = new Controls\AnyControl();
        $input->setLabel('rfg');
        $this->assertEmpty($input->getLabel());
        $input->setValue('edc');
        $this->assertEmpty($input->getValue());
        $input->setKey('rdx');
        $this->assertEquals('rdx', $input->getKey());
        $this->assertEmpty($input->render());
        $this->assertEmpty($input->renderLabel());
        $this->assertEmpty($input->renderInput());
        $this->assertEmpty($input->renderErrors([]));
    }

    /**
     * @throws FormsException
     */
    public function testInForm(): void
    {
        $form = new Form('testing');
        $toTest = new Controls\AnyControl();
        $toTest->setKey('uhb');
        $form->addControlDefaultKey($toTest);
        $form->setInputs(new \Adapter());
        $this->assertTrue($form->isValid());
    }

    public function testChangingControls(): void
    {
        $con1 = new Controls\Text();
        $con1->set('foo', 'zgv');
        $con1->setValue('tfc');
        $con1->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con2 = new Controls\Text();
        $con2->set('bar');
        $con2->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');

        $input = new Controls\AnyControl();
        $input->addControl('foo', $con1);
        $input->addControl('bar', $con2);

        $libVal = new Validate();
        $input->needAll(true);
        $this->assertFalse($input->validateControls($libVal));

        $input->needAll(false);
        $this->assertTrue($input->validateControls($libVal));
    }

    /**
     * @throws FormsException
     */
    public function testChangingControlsDeepNest(): void
    {
        $con1 = new Controls\Text(); // filled from adapter
        $con1->set('foo', 'zgv');
        $con1->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con2 = new Controls\Text(); // filled from adapter
        $con2->set('bar');
        $con2->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con3 = new Controls\Text(); // never filled
        $con3->set('bvt');
        $con3->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con4 = new Controls\Text(); // filled from adapter
        $con4->set('sgg');
        $con4->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');

        $input3 = new Controls\AnyControl();
        $input3->addControl('sgg', $con4);
        $input3->addControl('bvt', $con3);
        $input2 = new Controls\AnyControl();
        $input2->addControl('bar', $con2);
        $input2->addControl('mor', $input3);
        $input = new Controls\AnyControl();
        $input->addControl('ext', $input2);
        $input->addControl('foo', $con1);

        $adapter = new \Adapter();
        $form = new Form('testing');
        $form->addControlDefaultKey($input);
        $form->setInputs($adapter);

        $input->needAll(true);
        $input2->needAll(true);
        $input3->needAll(true);
        $form->setSentValues();
        $this->assertFalse($form->isValid());

        $input3->needAll(false);
        $form->setSentValues();
        $this->assertTrue($form->isValid());

        $input2->needAll(false);
        $form->setSentValues();
        $this->assertTrue($form->isValid());

        $input->needAll(false);
        $form->setSentValues();
        $this->assertTrue($form->isValid());

        $input->needAll(true);
        $input3->needAll(true);
        $form->setSentValues();
        $this->assertTrue($form->isValid());
    }

    public function testExistsControls(): void
    {
        $con3 = new Controls\Text();
        $con3->set('non');
        $con3->addRule(IRules::IS_NOT_EMPTY, 'might be empty');

        $input = new Controls\AnyControl();
        $this->assertEquals(0, $input->count());
        $this->assertFalse($input->hasControl('non'));
        $this->assertNull($input->getControl('non'));
        $input->addControl('non', $con3);
        $this->assertEquals(1, $input->count());
        $this->assertTrue($input->hasControl('non'));
        $this->assertIsObject($input->getControl('non'));
        $input->removeControl('non');
        $this->assertEquals(0, $input->count());
        $this->assertFalse($input->hasControl('non'));
        $this->assertNull($input->getControl('non'));
    }

    /**
     * @throws FormsException
     */
    public function testGettingControlsDeepNest(): void
    {
        $con1 = new Controls\Text(); // filled from adapter
        $con1->set('foo', 'zgv');
        $con1->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con2 = new Controls\Text(); // filled from adapter
        $con2->set('bar');
        $con2->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con3 = new Controls\Text(); // never filled
        $con3->set('bvt');
        $con3->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');
        $con4 = new Controls\Text(); // filled from adapter
        $con4->set('sgg');
        $con4->addRule(IRules::IS_NOT_EMPTY, 'must not be empty');

        $input2 = new Controls\AnyControl();
        $input2->addControl('bar', $con2);
        $input2->addControl('bvt', $con3);
        $input2->addControl('sgg', $con4);
        $input = new Controls\AnyControl();
        $input->addControl('foo', $con1);
        $input->addControl('mor', $input2);

        $input->needAll(true);
        $input2->needAll(true);

        $adapter = new \Adapter();
        $form = new Form('testing');
        $form->addControlDefaultKey($input);
        $form->setInputs($adapter);

        $this->assertNull($input->getControl('non'));
        $this->assertIsObject($input->getControl('foo'));
        $this->assertIsObject($input->getControl('sgg'));
        $this->assertEmpty($form->renderErrorsArray());

        $this->assertEquals(['foo' => '', 'bar' => '', 'bvt' => '', 'sgg' => '', ], $form->getLabels());
        $form->setLabels([
            'bvt' => 'rdc',
            'ofd' => 'gsa',
        ]);
        $this->assertEquals(['foo' => '', 'bar' => '', 'bvt' => 'rdc', 'sgg' => '', ], $form->getLabels());

        $form->setSentValues();
        $this->assertFalse($form->isValid());
        $this->assertNotEmpty($form->renderErrorsArray());
    }
}

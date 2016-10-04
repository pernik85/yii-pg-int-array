<?php

use pernik85\yiiPgIntArray\PgIntegerArrayBehavior;

/**
 * Class CRequiredValidator нужен для теста
 */
class CRequiredValidator {
    public $attributes = array('id');
}

/**
 * Class PgIntegerArrayValidator нужен для теста
 */
class PgIntegerArrayValidator  {
    public $attributes = array('parent_ids', 'afterSave');
}
class PgIntegerArrayBehaviorTest extends PHPUnit_Framework_TestCase
{

    protected $pgIntegerArrayBehaviorMock;

    protected function setUp(){
        $this->pgIntegerArrayBehaviorMock = $this->getMockBuilder('PgIntegerArrayBehavior')
            ->setMethods(array('addError', 'getValidators'))
            ->getMock();
    }

    public function test_init(){
        $dataValidators[0] = new CRequiredValidator();
        $dataValidators[1] = new PgIntegerArrayValidator();
        $this->pgIntegerArrayBehaviorMock->expects($this->once())
            ->method('getValidators')
            ->will($this->returnValue($dataValidators));
        $this->pgIntegerArrayBehaviorMock->init();
        $this->assertAttributeEquals($dataValidators[1]->attributes, 'arrayAttributes', $this->pgIntegerArrayBehaviorMock);
    }

    public function provider_getArrays(){
        return array(
            array('{1}', array(1)),
            array('{15,19,25}', array(15,19,25)),
        );
    }

    /**
     * @dataProvider provider_getArrays
     */
    public function test_afterSave($arrayPostgre, $expected){
        $arrayAttributes = array('parent_ids');
        $dataValidators = new PgIntegerArrayValidator();
        $dataValidators->$arrayAttributes[0] = $arrayPostgre;
        $this->pgIntegerArrayBehaviorMock->arrayAttributes = $arrayAttributes;
        $this->pgIntegerArrayBehaviorMock->parent_ids = $arrayPostgre;
        $this->pgIntegerArrayBehaviorMock->afterSave();

        $this->assertAttributeEquals($expected, 'parent_ids', $this->pgIntegerArrayBehaviorMock);
    }

    /**
     * @dataProvider provider_getArrays
     */
    public function test_afterFind($arrayPostgre, $expected){
        $arrayAttributes = array('parent_ids');
        $dataValidators = new PgIntegerArrayValidator();
        $dataValidators->$arrayAttributes[0] = $arrayPostgre;
        $this->pgIntegerArrayBehaviorMock->arrayAttributes = $arrayAttributes;
        $this->pgIntegerArrayBehaviorMock->parent_ids = $arrayPostgre;
        $this->pgIntegerArrayBehaviorMock->afterFind();

        $this->assertAttributeEquals($expected, 'parent_ids', $this->pgIntegerArrayBehaviorMock);
    }

    /**
     * @dataProvider provider_getStringFromArray_goodParams
     */
    public function test_getStringFromArray_goodParams($arrayPhp, $expected){
        $arrayAttributes = array('parent_ids');
        $dataValidators = new PgIntegerArrayValidator();
        $dataValidators->$arrayAttributes[0] = $arrayPhp;
        $this->pgIntegerArrayBehaviorMock->arrayAttributes = $arrayAttributes;
        $this->pgIntegerArrayBehaviorMock->parent_ids = $arrayPhp;

        $this->assertTrue($this->pgIntegerArrayBehaviorMock->beforeSave());
        $this->assertAttributeEquals($expected, 'parent_ids', $this->pgIntegerArrayBehaviorMock);

    }

    public function provider_getStringFromArray_goodParams(){
        return array(
            array(array(1),'{1}'),
            array(array(15,19,25), '{15,19,25}'),
        );
    }

}
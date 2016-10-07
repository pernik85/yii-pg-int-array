<?php

use pernik85\yiiPgIntArray\PgIntegerArrayBehavior;

/**
 * Class PgIntegerArrayBehaviorTest tests для PgIntegerArrayBehavior
 */

class PgIntegerArrayBehaviorTest extends PHPUnit_Framework_TestCase
{

    protected $pgIntegerArrayBehaviorMock;

    protected function setUp(){
        $this->pgIntegerArrayBehaviorMock = $this->getMockBuilder('PgIntegerArrayBehavior')
            ->setMethods(array('stringToArray'))
            ->getMock();
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
        $this->pgIntegerArrayBehaviorMock->arrayAttributes = $arrayAttributes;
        $this->pgIntegerArrayBehaviorMock->owner = (object)array('parent_ids' => $arrayPostgre);

        $this->pgIntegerArrayBehaviorMock->afterSave((object)array());
        $this->assertAttributeEquals($expected, 'parent_ids', $this->pgIntegerArrayBehaviorMock->owner);
    }

    /**
     * @dataProvider provider_getArrays
     */
    public function test_afterFind($arrayPostgre, $expected){
        $arrayAttributes = array('parent_ids');
        $this->pgIntegerArrayBehaviorMock->arrayAttributes = $arrayAttributes;
        $this->pgIntegerArrayBehaviorMock->owner = (object)array('parent_ids' => $arrayPostgre);

        $this->pgIntegerArrayBehaviorMock->afterFind((object)array());
        $this->assertAttributeEquals($expected, 'parent_ids', $this->pgIntegerArrayBehaviorMock->owner);
    }

    /**
     * @dataProvider provider_getStringFromArray_goodParams
     */
    public function test_getStringFromArray_goodParams($arrayPhp, $expected){
        $arrayAttributes = array('parent_ids');
        $this->pgIntegerArrayBehaviorMock->arrayAttributes = $arrayAttributes;
        $this->pgIntegerArrayBehaviorMock->owner = (object)array('parent_ids' => $arrayPhp);

        $this->pgIntegerArrayBehaviorMock->beforeSave((object)array());
        $this->assertAttributeEquals($expected, 'parent_ids', $this->pgIntegerArrayBehaviorMock->owner);

    }

    public function provider_getStringFromArray_goodParams(){
        return array(
            array(array(1),'{1}'),
            array(array(15,19,25), '{15,19,25}'),
        );
    }

}

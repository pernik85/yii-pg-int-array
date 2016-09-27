<?php

use pernik85\yiiPgIntArray\PgIntegerArrayBehavior;

class PgIntegerArrayBehaviorTest extends PHPUnit_Framework_TestCase
{

    protected $pgIntegerArrayBehaviorMock;

    protected function setUp(){
        $this->pgIntegerArrayBehaviorMock = $this->getMockBuilder('PgIntegerArrayBehavior')
            ->setMethods(array('addError'))
            ->getMock();
    }
    /**
     * @dataProvider provider_getArray_goodParams
     */
    public function test_getArray_goodParams($string, $expectedResponse){
        $this->assertEquals($expectedResponse, $this->pgIntegerArrayBehaviorMock->getArray($string));
    }

    public function provider_getArray_goodParams(){
        return array(
            array('{1}', array(1)),
            array('{15,19,25}', array(15,19,25)),
            array('{0,91,"hello world"}', array(0,91,"hello world")),
        );
    }

    public function test_getArray_withoutParams(){
        $this->assertNull($this->pgIntegerArrayBehaviorMock->getArray('{}'));
    }


    /**
     * @dataProvider provider_getStringFromArray_goodParams
     */
    public function test_getStringFromArray_goodParams($dataArray, $expectedResponse){
        $this->assertEquals($expectedResponse, $this->pgIntegerArrayBehaviorMock->getStringFromArray($dataArray));
    }

    public function provider_getStringFromArray_goodParams(){
        return array(
            array(array(1),'{1}'),
            array(array(15,19,25), '{15,19,25}'),
            array(array(0,91,'hello world'), "{0,91,'hello world'}"),
            array(array(0,91,"hello world"), "{0,91,'hello world'}")
        );
    }


    public function test_getStringFromArray_withEmptyParams(){
        $this->assertNull($this->pgIntegerArrayBehaviorMock->getStringFromArray(array()));
    }


}
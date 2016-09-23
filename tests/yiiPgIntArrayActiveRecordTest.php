<?php
require "src/yiiPgIntArrayActiveRecord.php";

class yiiPgIntArrayActiveRecordTest extends PHPUnit_Framework_TestCase
{

    protected $yiiPgIntArrayActiveRecord;

    protected function setUp(){
        $this->yiiPgIntArrayActiveRecord = $this->getMockBuilder('yiiPgIntArrayActiveRecord')
            ->setMethods(array('addError'))
            ->getMock();
    }

    /**
     * @dataProvider provider_getArray_goodParams
     */
    public function test_getArray_goodParams($string, $expectedResponse){
        $this->assertEquals($expectedResponse, $this->yiiPgIntArrayActiveRecord->getArray($string));
    }

    public function provider_getArray_goodParams(){
        return array(
            array('{1}', array(1)),
            array('{15,19,25}', array(15,19,25)),
            array('{0,91,"hello world"}', array(0,91,"hello world")),
        );
    }

    public function test_getArray_withoutParams(){
        $this->assertNull($this->yiiPgIntArrayActiveRecord->getArray('{}'));
    }


    /**
     * @dataProvider provider_getStringFromArray_goodParams
     */
    public function test_getStringFromArray_goodParams($dataArray, $expectedResponse){
        $this->assertEquals($expectedResponse, $this->yiiPgIntArrayActiveRecord->getStringFromArray($dataArray));
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
        $this->assertNull($this->yiiPgIntArrayActiveRecord->getStringFromArray(array()));
    }

    /**
     * @dataProvider provider_pgIntegerArrayValidator_badParams
     */
    public function test_pgIntegerArrayValidator_badParams($params, $messageError){
        $attribute = 'arrayInteger';

        $this->yiiPgIntArrayActiveRecord->expects($this->once())
            ->method('addError')
            ->with($this->equalTo($attribute), $this->equalTo($messageError));

        $this->yiiPgIntArrayActiveRecord->$attribute = $params;
        $this->assertEquals(null, $this->yiiPgIntArrayActiveRecord->pgIntegerArrayValidator($attribute, $params));
    }

    public function provider_pgIntegerArrayValidator_badParams(){
        return array(
            array(array(), 'Масив Пуст'),
            array(array(0,'91'), 'Масив содержит не понятные каракули'),
            array(array(0,91,"hello world"), 'Масив содержит не понятные каракули')
        );
    }


    /**
     * @dataProvider provider_pgIntegerArrayValidator_goodParams
     */
    public function test_pgIntegerArrayValidator_goodParams($paramsAttribute){
        $attribute = 'arrayInteger';
        $this->yiiPgIntArrayActiveRecord->expects($this->never())
            ->method('addError');

        $this->yiiPgIntArrayActiveRecord->$attribute = $paramsAttribute;
        $this->assertEquals(null, $this->yiiPgIntArrayActiveRecord->pgIntegerArrayValidator($attribute, array('allowEmpty' => true)));
    }

    public function provider_pgIntegerArrayValidator_goodParams(){
        return array(
            array(''),
            array(array(5,91))
        );
    }

}
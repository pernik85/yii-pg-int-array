<?php
use pernik85\yiiPgIntArray\PgIntegerArrayValidator;

class PgIntegerArrayValidatorTest extends PHPUnit_Framework_TestCase{

    protected $PgIntegerArrayValidatorMock;

    protected function setUp(){
        $this->PgIntegerArrayValidatorMock = $this->getMockBuilder('PgIntegerArrayValidator')
            ->setMethods(array('addError', 'isEmpty'))
            ->getMock();
    }
    /**
     * @dataProvider provider_pgIntegerArrayValidator_badParams
     */
    public function test_pgIntegerArrayValidator_badParams($params, $messageError){
        $attribute = 'arrayInteger';
        $object = (object)array('arrayInteger' => $params);
        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('isEmpty')
            ->with($this->equalTo($params))
            ->will($this->returnValue(false));

        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('addError')
            ->with($this->equalTo($object), $this->equalTo($attribute), $this->equalTo($messageError));

        $this->PgIntegerArrayValidatorMock->$attribute = $params;
        $this->assertEquals(null, $this->PgIntegerArrayValidatorMock->validateAttribute($object, $attribute));
    }

    public function provider_pgIntegerArrayValidator_badParams(){
        return array(
            array(167, '{attribute} должен быть массивом'),
            array(array(0,'91'), '{attribute} содержит не верные значение ({val})'),
            array(array(0,91,"hello world"), '{attribute} содержит не верные значение ({val})')
        );
    }


    /**
     * @dataProvider provider_pgIntegerArrayValidator_goodParams
     */
    public function test_pgIntegerArrayValidator_goodParamsNotEmpty($paramsAttribute){
        $attribute = 'arrayInteger';
        $object = (object)array('arrayInteger' => $paramsAttribute);
        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('isEmpty')
            ->with($this->equalTo($paramsAttribute))
            ->will($this->returnValue(false));
        $this->PgIntegerArrayValidatorMock->expects($this->never())
            ->method('addError');

        $this->PgIntegerArrayValidatorMock->$attribute = $paramsAttribute;
        $this->assertEquals(null, $this->PgIntegerArrayValidatorMock->validateAttribute($object, $attribute));
    }

    public function provider_pgIntegerArrayValidator_goodParams(){
        return array(
            array(array(5,91)),
            array(array(0, 15, 91)),
        );
    }

    public function test_pgIntegerArrayValidator_paramsEmpty(){
        $paramsAttribute = '';
        $attribute = 'arrayInteger';
        $object = (object)array('arrayInteger' => $paramsAttribute);
        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('isEmpty')
            ->with($this->equalTo($paramsAttribute))
            ->will($this->returnValue(true));
        $this->PgIntegerArrayValidatorMock->expects($this->never())
            ->method('addError');

        $this->PgIntegerArrayValidatorMock->$attribute = $paramsAttribute;
        $this->assertEquals(null, $this->PgIntegerArrayValidatorMock->validateAttribute($object, $attribute));
    }


    /**
     * @dataProvider provider_validate_badParams
     */
    public function test_validate_badParams($val, $exceptionMessage){

        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('isEmpty')
            ->with($this->equalTo($val))
            ->will($this->returnValue(false));

        $this->setExpectedException('Exception', $exceptionMessage);

       $this->PgIntegerArrayValidatorMock->validate($val);
    }


    public function provider_validate_badParams(){
        return array(
            array(159, 'не являеится массивом'),
            array(array(0, 15, '91'), 'массив содержит не верные значение'),
        );
    }

    /**
     * @dataProvider provider_validate_goodParams
     */
    public function test_validate_goodParams($val){

        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('isEmpty')
            ->with($this->equalTo($val))
            ->will($this->returnValue(false));


       $this->PgIntegerArrayValidatorMock->validate($val);
    }

    public function provider_validate_goodParams(){
        return array(
            array(array(159, 7)),
            array(array(0, 15, 91)),
        );
    }

    /**
     * @dataProvider provider_validate_emptyParams
     */
    public function test_validate_emptyParams($val){

        $this->PgIntegerArrayValidatorMock->expects($this->once())
            ->method('isEmpty')
            ->with($this->equalTo($val))
            ->will($this->returnValue(true));


       $this->PgIntegerArrayValidatorMock->validate($val);
    }

    public function provider_validate_emptyParams(){
        return array(
            array(array()),
            array(''),
        );
    }

}

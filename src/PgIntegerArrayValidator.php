<?php
namespace pernik85\yiiPgIntArray;


class PgIntegerArrayValidator extends CValidator
{
    /**
     * @var string Сообщение о не верном значении в массиве
     */
    public $errorArray;
    /**
     * @var boolean значение атрибута может быть нулевым или пустым. По умолчанию, true,
     */
    public $allowEmpty=true;

    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    public function validateAttribute($object,$attribute)
    {
        $value = $object->$attribute;
        if($this->allowEmpty && $this->isEmpty($value))
            return;

        if(!is_array($value))
        {
            $message = $this->message !== null ? $this->message : Yii::t('yii','{attribute} должен быть массивом');
            $this->addError($object,$attribute,$message);
            return;
        }

        foreach($value as  $val) {
            if(!is_int($val)){
               $message = $this->errorArray = $this->errorArray !== null ? $this->errorArray : Yii::t('yii','{attribute} содержит не верные значение ({val})');

                $this->addError($object,$attribute, $message, array('val' => $val));
            }
        }
    }
}

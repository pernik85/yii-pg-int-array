<?php


class yiiPgIntArrayActiveRecord
{

    /**
     * Преобразует массив PostgreSQL в массив php
     * 
     * @param string $string массив элементов в формате PostgreSQL ({1,2,3...})
     * 
     * @return array
     */
    public function getArray($string)
    {
        $string = str_replace(array('{', '}'), '', $string);
        if (empty($string)) {
            return null;
        }
        $string = str_replace(array("'", '"'), '', $string);
        $array = explode(',', $string);
        return $array;
    }
    /**
     * Преобразует  массив php в массив PostgreSQL
     *
     * @param  array $array
     *
     * @return string
     */
    public function getStringFromArray($array)
    {
        $stringArray = null;
        if (is_array($array) && count($array) > 0) {
            $stringArray = '{' . join(",", array_map(function($v){
                    return is_int($v) ? $v : "'".$v."'";
                },$array)) . '}';
        }
        return $stringArray;
    }

    /**
     * Валидатор. Проверяет является ли заданный аттрибут массивом с integer значениями
     *
     * @param string $attribute название атрибута
     * @param array  $params дополнительные параметры
     *
     * @return void
     */
    public function pgIntegerArrayValidator ($attribute, $params)
    {
        $allowEmpty = false;
        if (isset($params['allowEmpty']) && is_bool($params['allowEmpty'])) {
            $allowEmpty = $params['allowEmpty'];
        }
        if (!is_array($this->$attribute)  && !$allowEmpty){
            $this->addError($attribute, 'Это не Массив');
        }
        if(empty($this->$attribute)){
            $this->addError($attribute, 'Масив Пуст');
        }
        foreach($this->$attribute as  $value) {
            if(!is_int($value)){
                $this->addError($attribute, 'Масив содержит не понятные каракули');
                break;
            }
        }
    }

}
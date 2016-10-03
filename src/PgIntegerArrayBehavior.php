<?php
//namespace pernik85\yiiPgIntArray;
/**
 * Class yiiPgIntArrayActiveRecord росширяет CActiveRecord для работы с int[] PostgreSQL
 */

class PgIntegerArrayBehavior //extends CActiveRecord
{

    public $arrayAttributes = null;


    public function init1(){
        $this->arrayAttributes = 'sfs';
    }
    public function init(){
        if(!$this->arrayAttributes){
            foreach($this->getValidators() as $validator){
                if(get_class($validator) == 'PgIntegerArrayValidator' ){
                    $this->arrayAttributes = $validator->attributes;
                    break;
                }
            }
//            var_dump($this->arrayAttributes);
        }
    }

    /**
     * Преобразует  массив php в массив PostgreSQL перед сохранением
     * @return bool
     */
    public function beforeSave(){
        if(parent::beforeSave()){
            foreach($this->arrayAttributes as $nameAttribute){
                $this->$nameAttribute = '{' . join(",", $this->$nameAttribute) . '}';
            }
            return true;
        }
        return false;
    }

    /**
     * Преобразует массив PostgreSQL в массив php после сохранения
     */
    public function afterSave(){
        $this->stringToArray();
        parent::afterSave();
    }

    /**
     * Преобразует массив PostgreSQL в массив php после поиска
     */
    public function afterFind(){
        $this->stringToArray();
        parent::afterFind();
    }

    /**
     * Преобразует массив PostgreSQL в массив php
     */
    private function stringToArray(){
        foreach($this->arrayAttributes as $nameAttribute){
            $this->$nameAttribute = str_replace(array('{', '}'), '', $this->$nameAttribute);
            $this->$nameAttribute = explode(',', $this->$nameAttribute);
        }
    }
}

<?php
namespace pernik85\yiiPgIntArray;
/**
 * Class yiiPgIntArrayActiveRecord росширяет CActiveRecord для работы с int[] PostgreSQL
 */

class PgIntegerArrayBehavior extends CActiveRecordBehavior
{

    /**
     * @var null массив полей котрые
     */
    public $arrayAttributes = null;

    /**
     * Преобразует  массив php в массив PostgreSQL перед сохранением
     */
    public function beforeSave($event){
        if(is_array($this->arrayAttributes) && !empty($this->arrayAttributes)){
            foreach($this->arrayAttributes as $nameAttribute){
                $this->owner->$nameAttribute = '{' . join(",", $this->owner->$nameAttribute) . '}';
            }
        }
    }

    /**
     * Преобразует массив PostgreSQL в массив php после сохранения
     */
    public function afterSave($event){
        $this->stringToArray();
        return true;
    }

    /**
     * Преобразует массив PostgreSQL в массив php после поиска
     */
    public function afterFind($event){
        $this->stringToArray();
    }

    /**
     * Преобразует массив PostgreSQL в массив php
     */
    private function stringToArray(){
        if(is_array($this->arrayAttributes) && !empty($this->arrayAttributes)) {
            foreach ($this->arrayAttributes as $nameAttribute) {
                $attribute = str_replace(array('{', '}'), '', $this->owner->$nameAttribute);
                $this->owner->$nameAttribute = explode(',', $attribute);
            }
        }
    }
}

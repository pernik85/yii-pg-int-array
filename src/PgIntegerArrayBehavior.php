<?php
namespace pernik85\yiiPgIntArray;
/**
 * Class yiiPgIntArrayActiveRecord росширяет CActiveRecord для работы с int[] PostgreSQL
 */

class PgIntegerArrayBehavior extends CActiveRecord
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


}
<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/14
 * Time: 11:07
 */

namespace App\Http\Service\Utils;


class ConvertHelper
{
   public static function array2object($array) {
        if (is_array($array)) {
            $obj = new StdClass();
            foreach ($array as $key => $val){
                $obj->$key = $val;
            }
        }
        else { $obj = $array; }
        return $obj;
    }
  public  static  function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }
}
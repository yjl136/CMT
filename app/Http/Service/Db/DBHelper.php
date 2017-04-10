<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 17:03
 */

namespace App\Http\Service\Db;

use Illuminate\Support\Facades\DB;

class DBHelper extends DBBase{
    public static function saveOrUpdate($sql){
        return self::query($sql);
    }

    public static function save($table, $params){
        $columns = array();
        $values = array();
        foreach($params as $col => $val){
            $columns[] = $col;
            $values[] = "'$val'";
        }
        $sql = "INSERT INTO $table (".implode(',', $columns).") VALUES (".implode(',', $values).")";
        return DB::insert($sql);
    }

    public static function delete($sql){
        return self::query($sql);
    }
}
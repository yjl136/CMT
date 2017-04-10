<?php
namespace App\Http\Service\Db;
use Illuminate\Support\Facades\DB;

class DBBase{
    public static function getList($sql){
        $result=DB::select($sql);
        return $result;
    }

    public static function getOne($sql){
        global $_SGLOBAL;
        $query = $_SGLOBAL['db']->query($sql);
        $result = $_SGLOBAL['db']->fetch_array($query);
        mysql_free_result($query);
        $_SGLOBAL['db']->log_sql(sprintf("Query row: %s", print_r($result, true)));
        return $result;
    }

    public static function getCount($sql){
        global $_SGLOBAL;
        $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql), 0);
        $_SGLOBAL['db']->log_sql(sprintf("Query count: %d", $count));
        return $count;
    }

    public static function query($sql){
        global $_SGLOBAL;
        $db = $_SGLOBAL['db'];
        $db->query($sql);
        return $db->affected_rows();
    }

    public static function add($sql){
        global $_SGLOBAL;
        $db = $_SGLOBAL['db'];
        $db->query($sql);
        return $db->insert_id();
    }
}
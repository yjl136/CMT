<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 15:50
 */

namespace App\Http\Service\Base;


use App\Http\Service\Consts;
use App\Http\Service\Db\DBHelper;
use Illuminate\Support\Facades\Session;

class BaseService
{

    /**
     * 查询分页数据
     *
     * @param $count_sql		查询总数的sql
     * @param $query_sql		查询数据的sql
     * @param $page				当前页码
     * @param $rowsPerPage		每页行数
     * @param $callback			回调函数，用于处理查询出来的数据
     * @param $param			回调函数的额外参数
     */
    public function getPageList($count_sql, $query_sql, $page, $rowsPerPage = DEFAULT_ROWS_PER_PAGE, $callback = null, $param = null){
        //获取数据总数
        $count = DBHelper::getCount($count_sql);
        //分页类实例
        $pager = new Pager($count, $page, $rowsPerPage);
        //查询一页数据
        $limit = $pager->getLimit();
        $query_sql = $query_sql.$limit;
        $list = DBHelper::getList($query_sql);
        //如果需要对list中的数据进行处理，执行回调函数
        if(is_callable(array($this, $callback))){
            call_user_func_array(array($this, $callback), array(&$list, $param));
        }
        return $pager->getPager($list);
    }

    public function logOperation($logMsg, $equipment = 'CMT'){
        //记录日志$_SESSION['cmt_user_type'],//操作人
        $user = Session::get('cmt_user_type', 'config');
        $data = array(
            'operate_time'	=> date('Y-m-d H:i:s',time()),//操作时间
            'operater'		=> $user,
            'comment'		=> $logMsg,//操作描述
            'equipment'		=> $equipment//操作设备
        );
        return DBHelper::save(Consts::CMT_OPERATE, $data);
    }

    public function getAvailCateList(){
        $baseDAO = new BaseDAO();
        return $baseDAO->getAvailCateList();
    }

    public function getAvailStatList(){
        $stat_list = array("WiFi", "3G", "WoW", "PA");

        if(defined("PLUGIN_CPE") && PLUGIN_CPE){
            array_push($stat_list, "ATG");
        }

        if(defined("PLUGIN_KU") && PLUGIN_KU){
            array_push($stat_list, "Ku");
        }

        if(defined("PLUGIN_TWLU") && PLUGIN_TWLU){
            array_push($stat_list, "TWLU");
        }
        return $stat_list;
    }
}
<?php
namespace App\Http\Service\Db;
use App\Http\Service\Consts;
use Illuminate\Support\Facades\Session;

class BaseDAO{
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
		//记录日志

		$user = Session::get('cmt_user_type');
		$data = array(
			'operate_time'	=> date('Y-m-d H:i:s',time()),//操作时间
			'operater'		=> $user,//操作人
			'comment'		=> $logMsg,//操作描述
			'equipment'		=> $equipment//操作设备
		);

		return DBHelper::save(Consts::CMT_OPERATE, $data);
	}

	/**
	 * 获取已配置的设备类型
	 *
	 */
	public function getAvailCateList(){
		$cate_list = array(Consts::DEV_TYPE_CMT,Consts::DEV_TYPE_SERVER);//默认包含：CMT,Server

		//根据AP模式判断，当前使用的CAP类型
		switch (Consts::AP_MODE_DEFAULT){
			case Consts::AP_MODE_CAP2K:
				array_push($cate_list, Consts::DEV_TYPE_CAP);
				break;
				
			case Consts::AP_MODE_KONTRON:
				array_push($cate_list, Consts::DEV_TYPE_CAP_KONTRON);
				break;
				
			default://默认使用APs模式
				array_push($cate_list, Consts::DEV_TYPE_APS);
				break;
		}
		
		if(defined("PLUGIN_ADB") && Consts::PLUGIN_ADB){
			array_push($cate_list, Consts::DEV_TYPE_ADB);
		}

		if(defined("PLUGIN_CPE") && Consts::PLUGIN_CPE){
			array_push($cate_list, Consts::DEV_TYPE_CPE);
		}

		if(defined("PLUGIN_KU") && Consts::PLUGIN_KU){
			array_push($cate_list, DEV_TYPE_KU);
		}

		if(defined("PLUGIN_TWLU") && Consts::PLUGIN_TWLU){
			array_push($cate_list, Consts::DEV_TYPE_TWLU);
		}

		return implode(",", $cate_list);
	}

	public function getValueList($list, $key){
		$result = array();
		if(count($list)){
			$result = array_map(array($this, "getValueCallBack"), $list, array_fill(0, count($list), $key));
		}
		return $result;
	}

	/**
	 * 获取列表中指定key的value的回调函数，使用方法：
	 * //获取list中id的值
	 * $result = array_map(array($this, "getValueCallBack"), $list, array_fill(0, count($list), "id"));
	 *
	 */
	public function getValueCallBack($row, $key){
		return $row[$key];
	}
}
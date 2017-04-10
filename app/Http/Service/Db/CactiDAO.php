<?php
namespace App\Http\Service\Db;
// cacti数据库名称
define ( "CACTI_DB_NAME", "cacti" );

// 图形模板ID
define ( "GRAPH_CPU_CMT", 39 );
define ( "GRAPH_CPU_SERVER", 36 );
define ( "GRAPH_CPU_USAGE", 4 );
define ( "GRAPH_CPU_TEMPERTUR", 35 );
define ( "GRAPH_MEMROY", 13 );
define ( "GRAPH_HARDDISK", 26 );
define ( "GRAPH_NETWORK", 2 );

/**
 * CactiDAO: 用于获取Cacti相关数据信息
 *
 * @author Luke Huang 2014-8-19
 *        
 */
class CactiDAO extends BaseDAO {

	/**
	 * 验证该类型的设备是否支持图形监控
	 *
	 * @param integer $dev_type        	
	 * @return boolean
	 */
	public function isSupport($dev_type) {
		$is_support = false;
		switch ($dev_type) {
			case DEV_TYPE_CMT :
			case DEV_TYPE_SERVER :
			case DEV_TYPE_APS :
				$is_support = true;
				break;
			
			default :
				break;
		}
		return $is_support;
	}

	/**
	 * 获取设备对应的图形监控时间间隔
	 *
	 * @param integer $dev_type        	
	 * @return array: 可以使用的时间间隔
	 */
	public function getTimePeriods($dev_type) {
		switch ($dev_type) {
			case DEV_TYPE_CMT :
			case DEV_TYPE_SERVER :
			case DEV_TYPE_APS :
				$time_priods = array ( // 时长（s） ==> 时长名称
						1800 => Trans::t ( "半小时" ),
						3600 => Trans::t ( '一小时' ),
						86400 => Trans::t ( '一天' ),
						604800 => Trans::t ( '一周' ) 
				);
				break;
			
			default :
				$time_priods = array ();
				break;
		}
		return $time_priods;
	}

	/**
	 * 获取设备对应的图形模板以及模板名称
	 *
	 * @param integer $dev_type        	
	 * @return array: 图形模板ID
	 */
	public function getGraphTypes($dev_type) {
		switch ($dev_type) {
			case DEV_TYPE_CMT :
				$types = array (
						GRAPH_CPU_USAGE => Trans::t ( 'CPU利用率' ),
						GRAPH_CPU_TEMPERTUR => Trans::t ( 'CPU温度' ),
						GRAPH_MEMROY => Trans::t ( '内存' ),
						GRAPH_HARDDISK => Trans::t ( '硬盘' ),
						GRAPH_NETWORK => Trans::t ( '网络传输' ) 
				);
				break;
			
			case DEV_TYPE_SERVER :
				$types = array (
						GRAPH_CPU_USAGE => Trans::t ( 'CPU利用率' ),
						GRAPH_CPU_TEMPERTUR => Trans::t ( 'CPU温度' ),
						GRAPH_MEMROY => Trans::t ( '内存' ),
						GRAPH_HARDDISK => Trans::t ( '硬盘' ),
						GRAPH_NETWORK => Trans::t ( '网络传输' ) 
				);
				break;
			
			case DEV_TYPE_APS :
				$types = array (
						GRAPH_NETWORK => Trans::t ( '网络传输' ) 
				);
				break;
			
			default :
				$types = array ();
				break;
		}
		return $types;
	}

	/**
	 * 根据主机IP地址和图形模板类型，获取指定时间范围内的统计图形url列表
	 *
	 * @param string $host        	
	 * @param integer $graph_template_id        	
	 * @param integer $time_period        	
	 * @param integer $width        	
	 * @param number $height        	
	 * @return array: 图片url数组
	 */
	public function getGraphUrls($host, $graph_template_id, $time_period, $width, $height) {
		// 根据IP地址，获取对应的图形ID
		$graph_local_ids = $this->_getGraphLocalIds ( $host, $graph_template_id );
		
		// 生成所有的图片URL
		$graph_urls = array ();
		foreach ( $graph_local_ids as $graph_id ) {
			array_push ( $graph_urls, $this->_getGraphUrl ( $graph_id, $time_period, $width, $height ) );
		}
		return $graph_urls;
	}
	
	/**
	 * 通过主机IP和图形模板ID，获取该类型的所有图形对应的ID
	 *
	 * @param string $host        	
	 * @param string $graph_template_id        	
	 * @return array: 所有图形ID的数组
	 */
	private function _getGraphLocalIds($host, $graph_template_id) {
		// cacti数据库名
		$db_name = CACTI_DB_NAME;
		$sql = "SELECT gl.id FROM $db_name.`graph_local` gl LEFT JOIN $db_name.`host` h ON gl.host_id = h.id WHERE h.hostname = '$host' AND gl.graph_template_id = '$graph_template_id' ORDER BY gl.id";
		$list = DBHelper::getList ( $sql );
		$graph_local_ids = $this->getValueList ( $list, "id" );
		return $graph_local_ids;
	}

	/**
	 * 获取图片对应的链接：
	 * 如果是本机访问，图片地址映射为192.168.2.99服务器的图片地址
	 * 如果是远程访问，指向服务器对应的主机。使用 $_SERVER ['HTTP_HOST']可以解决使用反向代理方式图片无法访问的问题。
	 *
	 * @param integer $graph_id        	
	 * @param integer $time_period        	
	 * @param integer $width        	
	 * @param integer $height        	
	 * @return string 图片链接
	 */
	private function _getGraphUrl($graph_id, $time_period, $width, $height) {
		$now = time ();
		$start = $now - $time_period;
		$url = sprintf ( "http://%s/cacti/graph_image.php?local_graph_id=%s&graph_start=%s&graph_end=%s&graph_width=%s&graph_height=%s", $_SERVER ['HTTP_HOST'] == "localhost" ? sprintf ( "%s:%s", SERVER_IP, SERVER_APACHE_PORT ) : $_SERVER ['HTTP_HOST'], $graph_id, $start, $now, $width, $height );
		return $url;
	}
	
	/**
	 * 重置cacti中poller的最后一次运行时间，保证poller始终运行
	 * 
	 * @param string $time
	 */
	public function resetPollerLastRunTime($time){
		$unix_time = strtotime ( $time );
		$sql = "UPDATE ".CACTI_DB_NAME.".`settings` SET value = '$unix_time' where name = 'poller_lastrun' limit 1";
		DBHelper::saveOrUpdate ( $sql );
	}
}
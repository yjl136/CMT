<?php
namespace App\Http\Service\Db;
// 定义设备信息类型
use App\Http\Service\Consts;
use Illuminate\Support\Facades\DB;

define ( 'DEV_INFO_DEV', 1 ); // 设备信息
define ( 'DEV_INFO_SUB_DEV', 2 ); // 子设备信息
define ( 'DEV_INFO_APP', 3 ); // 应用信息
define ( 'DEV_INFO_HARDDISK', 4 ); // 硬盘信息
define ( 'DEV_INFO_PHYSIC', 5 ); // 物理信息
define ( 'DEV_INFO_STATUS', 6 ); // 状态信息

/**
 * ExeDeviceDAO: 作为DeviceDAO的扩展
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class ExtDeviceDAO extends BaseDAO {
	
	/**
	 * 获取指定页的设备数据
	 *
	 * @param integer $page        	
	 * @return array: 返回一页设备数据
	 */
	public function getDeviceList($page) {
		// 查询总数的sql
		$count_sql = "SELECT COUNT(DevID) FROM " . OAM_DEVICE_DETAIL . " WHERE DevType in (" . $this->getAvailCateList () . ")";
		// 查询数据的sql
		$query_sql = "SELECT * FROM " . OAM_DEVICE_DETAIL . " od WHERE od.DevType in (" . $this->getAvailCateList () . ") ORDER BY od.DevType";
		// 查询一页数据
		$pager = $this->getPageList ( $count_sql, $query_sql, $page, DEFAULT_ROWS_PER_PAGE, 'formatDeviceList' );
		return $pager;
	}
	
	/**
	 * 对设备列表进行格式化输出
	 * 注意：设备列表参数需要传引用
	 *
	 * @param array $list
	 *        	设备列表的引用
	 * @param array $param
	 *        	额外参数
	 */
	public function formatDeviceList(&$list) {
		$device_formatter = DeviceFormatter::getInstance ();
		foreach ( $list as  $key=>$device ) {
			$device_formatter->formatDevice ($list[$key] );
		}
	}
	public function getAllDevice() {
		$sql = "SELECT * FROM " . OAM_DEVICE_DETAIL . " od WHERE od.DevType in (" . $this->getAvailCateList () . ") ORDER BY od.DevType";
		$list = DBHelper::getList ( $sql );
		$this->formatDeviceList ( $list );
		return $list;
	}
	
	/**
	 * 根据设备类型，获取该类型的所有设备列表
	 *
	 * @param integer $dev_type
	 *        	设备类型
	 * @return array 指定类型的设备列表
	 */
	public function getDeviceListByDevType($dev_type, $limit_one = false) {
		$condition = empty ( $dev_type ) ? "" : " AND od.DevType = '$dev_type'";
		$sql = "SELECT * FROM " .Consts:: OAM_DEVICE_DETAIL . " od WHERE od.DevType in (" . $this->getAvailCateList () . ") $condition ORDER BY od.DevType, od.DevPosition";
		if ($limit_one) {
			$sql .= " LIMIT 1";
			$device = DBHelper::getOne ( $sql );
			DeviceFormatter::getInstance ()->formatDevice ( $device );
			return $device;
		} else {
			$list = DBHelper::getList ( $sql );
			$this->formatDeviceList ( $list );
			return $list;
		}
	}
	
	/**
	 * 根据设备ID，查询设备信息
	 *
	 * @param string $dev_id        	
	 * @return array<string, string>
	 */
	public function getDevice($dev_id) {
		$adapter = new DeviceAdapter ();
		$device = $adapter->getDeviceDetail ( $dev_id, Consts::DEV_INFO_DEV, '' );
		return $device;
	}
	
	/**
	 * 根据设备ID和信息类型，获取设备相关信息， 用于设备详情页面和自检详情页面的数据显示
	 *
	 * @param string $dev_id
	 *        	设备ID
	 * @param integer $type
	 *        	信息类型可以作以下取值：
	 *        	DEV_INFO_DEV
	 *        	DEV_INFO_SUB_DEV
	 *        	DEV_INFO_APP
	 *        	DEV_INFO_HARDDISK
	 *        	DEV_INFO_PHYSIC
	 *        	DEV_INFO_STATUS
	 *        	欲了解信息类型获取的详细信息，请参考WiFi-4000软件设计说明书
	 *        	
	 * @return mixed 指定类型的信息，一般为数组类型
	 */
	public function getDeviceDetail($dev_id, $type, $bite_time) {
		$adapter = new DeviceAdapter ();
		return $adapter->getDeviceDetail ( $dev_id, $type, $bite_time );
	}
	
	/**
	 * 获取设备列表：
	 * 若有设备类型参数，则返回指定的设备类型
	 * 若无设备类型参数，则返回所有可操作的设备类型
	 *
	 * @param string $dev_type        	
	 * @return array
	 */
	public function getDeviceCategory($dev_type = '') {
		if (empty ( $dev_type )) {
			// 查询数据的sql
			$sql = "SELECT ID, Name FROM " . OAM_DEVICE_CATEGORY . " WHERE ID in (" . $this->getAvailCateList () . ") ORDER BY ID";
			return DBHelper::getList ( $sql );
		} else {
			// 查询数据的sql
			$sql = "SELECT ID, Name FROM " . OAM_DEVICE_CATEGORY . " WHERE ID = '$dev_type' LIMIT 1";
			return DBHelper::getOne ( $sql );
		}
	}
	
	/**
	 * 根据设备ID以及参数类型，获取对应的参数值，主要用于获取设备的信号状态
	 *
	 * @param string $dev_id
	 *        	设备ID
	 * @param integer $param_type
	 *        	参数类型
	 */
	public function getParamValue($dev_id, $param_type) {
		$sql = "SELECT obpv.ParamValue FROM " . OAM_BITE_PARAM_VALUE . " obpv LEFT JOIN " . OAM_MONITOR_PARAM . " omp ON omp.ID = obpv.ParamID WHERE obpv.DeviceID = '$dev_id' AND omp.ParamType = '$param_type' LIMIT 1";
		$row = DBHelper::getOne ( $sql );
		return $row ["ParamValue"];
	}
	public function getParamMap() {
		$sql = "SELECT * FROM " . OAM_PARAM_MAP;
		$list = DBHelper::getList ( $sql );
		$map = array ();
		foreach ( $list as $value ) {
			$param_id = $value ["ParamID"];
			$map [$param_id] ["AppName"] = $value ["AppName"];
			$map [$param_id] ["CategoryID"] = $value ["CategoryID"];
			$map [$param_id] ["CategoryName"] = $value ["CategoryName"];
			$map [$param_id] ["ParamType"] = $value ["ParamType"];
			$map [$param_id] ["ParamName"] = Trans::t ( $value ["ParamName"] );
		}
		return $map;
	}
	public function getMonitorParamValueList($page, $params) {
		$dev_type = $params ["dev_type"];
		$start_time = $params ["start_time"];
		$end_time = $params ["end_time"];
		
		$condition = " WHERE 1=1 ";
		$dev_list = empty ( $dev_type ) ? $this->getAllDevice () : $this->getDeviceListByDevType ( $dev_type );
		if (count ( $dev_list ) > 0) {
			$dev_id_list = $this->getValueList ( $dev_list, "DevID" );
			$condition .= " AND DeviceID in ('" . implode ( "','", $dev_id_list ) . "') ";
		}
		if (! empty ( $start_time ) && ! empty ( $end_time )) {
			$condition .= " AND CreateTime between '$start_time' AND '$end_time' ";
		}
		
		// 查询总数的sql
		$count_sql = "SELECT COUNT(ID) FROM " . OAM_MONITOR_PARAM_VALUE . " $condition";
		// 查询数据的sql
		$query_sql = "SELECT DeviceID, ParamID, ParamValue, CreateTime FROM " . OAM_MONITOR_PARAM_VALUE . " $condition ORDER BY CreateTime DESC";
		// 查询一页数据
		$result = $this->getPageList ( $count_sql, $query_sql, $page, DEFAULT_ROWS_PER_PAGE, "formatParamValue", $this->getParamMap () );
		return $result;
	}
	public function formatParamValue($list, $params) {
		$devname_list = array ();
		$dev_list = $this->getAllDevice ();
		foreach ( $dev_list as $device ) {
			$devname_list [$device ["DevID"]] = $device ["NameText"];
		}
		
		foreach ( $list as $key => $value ) {
			$param_id = $value ["ParamID"];
			$list [$key] ["CategoryName"] = $devname_list [$value ["DeviceID"]]; // $params [$param_id] ["CategoryName"];
			$list [$key] ["AppName"] = $params [$param_id] ["AppName"];
			$list [$key] ["ParamName"] = Trans::t ( $params [$param_id] ["ParamName"] );
			$list [$key] ["ParamValue"] = DeviceFormatter::getInstance ()->formatParamValue ( $params [$param_id] ["ParamType"], $value ["ParamValue"] );
			$list [$key] ["CreateTime"] = formatUTCDateTime ( $value ["CreateTime"] );
		}
		return $list;
	}
}

/**
 * IDevice: 设备通用接口
 *
 * @author Luke Huang 2014-8-18
 *        
 */
interface IDevice {
	
	/**
	 * 获取设备详细信息
	 *
	 * @param string $dev_id        	
	 */
	public function getDevice($dev_id);
	
	/**
	 * 根据类型，获取设备的指定类型信息
	 *
	 * @param string $dev_id
	 *        	设备ID
	 * @param integer $type
	 *        	信息类型可以作以下取值：
	 *        	DEV_INFO_DEV
	 *        	DEV_INFO_SUB_DEV
	 *        	DEV_INFO_APP
	 *        	DEV_INFO_HARDDISK
	 *        	DEV_INFO_PHYSIC
	 *        	DEV_INFO_STATUS
	 *        	欲了解信息类型获取的详细信息，请参考WiFi-4000软件设计说明书
	 *        	
	 * @return array 返回指定类型的信息
	 */
	public function getDeviceDetail($dev_id, $type, $bite_time);
}

/**
 * Device： 设备通用接口实现类
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class DeviceAdapter implements IDevice {
	public $adaptee;
	
	/**
	 * 根据设备ID获取设备信息
	 *
	 * @see IDeviceAdapter::getDevice()
	 */
	public function getDevice($dev_id) {
		$sql = "SELECT * FROM " . Consts::OAM_DEVICE_DETAIL . " WHERE DevID = '$dev_id' LIMIT 1";
		//$device = DBHelper::getOne ( $sql );
		$device = DB::select($sql);
		DeviceFormatter::getInstance ()->formatDevice ( $device[0] );
		return $device;
	}
	
	/**
	 * 根据类型，获取设备信息
	 *
	 * @see IDeviceAdapter::getDeviceDetail()
	 */
	public function getDeviceDetail($dev_id, $type, $bite_time) {
		// 获取当前设备信息
		$device = $this->getDevice ( $dev_id );
		// 获取设备对应的适配者
		$this->_initAdaptee ( $device[0]->DevType);
		
		return $this->adaptee->_getDeviceDetail ( $dev_id, $type, $bite_time );
	}
	
	/**
	 * 根据设备类型，初始化适配者
	 *
	 * @param integer $dev_type        	
	 */
	private function _initAdaptee($dev_type) {
		switch ($dev_type) {
			case Consts::DEV_TYPE_CMT :
				$this->adaptee = new CMTDevice ();
				break;
			
			case Consts::DEV_TYPE_SERVER :
				$this->adaptee = new ServerDevice ();
				break;
			
			case Consts::DEV_TYPE_ADB :
				$this->adaptee = new ADBDevice ();
				break;
			
			case Consts::DEV_TYPE_APS :
				$this->adaptee = new APsDevice ();
				break;
			
			case Consts::DEV_TYPE_CPE :
				$this->adaptee = new CPEDevice ();
				break;
			
			case Consts::DEV_TYPE_CAP :
				$this->adaptee = new CAP2KDevice ();
				break;
			
			case Consts::DEV_TYPE_CAP_KONTRON :
				$this->adaptee = new CAPKontronDevice ();
				break;
			default :
				break;
		}
	}
	
	/**
	 *
	 * @param string $dev_id        	
	 * @param integer $type        	
	 * @return array
	 */
	protected function _getDeviceDetail($dev_id, $type, $bite_time) {
		switch ($type) {
			case DEV_INFO_DEV :
				$result = $this->getDevice ( $dev_id );
				break;
			
			case DEV_INFO_SUB_DEV :
				$result = $this->_getSubDeviceList ();
				break;
			
			case DEV_INFO_APP :
				$result = $this->_getApplicationInfo ( $dev_id, $bite_time );
				break;
			
			case DEV_INFO_HARDDISK :
				$result = $this->_getHarddiskInfo ( $dev_id, $bite_time );
				break;
			
			case DEV_INFO_PHYSIC :
				$result = $this->_getPhysicInfo ( $dev_id, $bite_time );
				break;
			
			case DEV_INFO_STATUS :
				$result = $this->_getStatusInfo ( $dev_id, $bite_time );
				break;
			
			default :
				break;
		}
		return $result;
	}
	
	/**
	 * 获取子设备列表
	 *
	 * @return array:
	 */
	protected function _getSubDeviceList() {
		return array ();
	}
	
	/**
	 * 根据设备ID和参数分组ID， 获取对应的自检参数值
	 *
	 * @param string $dev_id        	
	 * @param integer $group_id        	
	 */
	protected function _getBiteParamValue($dev_id, $group_id, $bite_time) {
		if (empty ( $bite_time )) {
			$conditions = "AND obpv.CreateTime >= '$bite_time'";
		}
		
		$sql = "SELECT * FROM " . OAM_BITE_PARAM_VALUE . " obpv LEFT JOIN " . OAM_PARAM_MAP . " opm ON obpv.ParamID = opm.ParamID WHERE obpv.DeviceID  = '$dev_id' AND opm.GroupID = '$group_id' $conditions ORDER BY opm.ParamType";
		return DBHelper::getList ( $sql );
	}

//	protected function _getBiteParamValue_cap2k($dev_id,$bite_time) {
//		if (empty ( $bite_time )) {
//			$conditions = "AND obpv.CreateTime >= '$bite_time'";
//		}
//		$sql = "SELECT * FROM " . OAM_BITE_PARAM_VALUE . " obpv LEFT JOIN " . OAM_PARAM_MAP . " opm ON obpv.ParamID = opm.ParamID WHERE obpv.DeviceID  = '$dev_id' $conditions ORDER BY opm.ParamType";
//		return DBHelper::getList ( $sql );
//	}
	
	/**
	 * 获取应用信息
	 *
	 * @param string $dev_id        	
	 * @return array <string, <string, mixed>>
	 */
	protected function _getApplicationInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_APP, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatAppInfo ( $list );
		return $result;
	}
	
	/**
	 * 获取最新的硬盘自检信息
	 *
	 * @param string $dev_id        	
	 * @return array
	 */
	protected function _getHarddiskInfo($dev_id, $bite_time) {
//		$max_time = empty ( $bite_time ) ? $this->_getMaxTimeofHarddisk ( $dev_id ) : $bite_time;
		$max_time = $this->_getMaxTimeofHarddisk ( $dev_id );
		$sql = "SELECT * FROM (SELECT DISTINCT ohd.Partion, ohd.DiskAvail, ohd.DiskTotal, ohd.DiskPercent FROM " . OAM_HARD_DISK_PARAM . " ohd WHERE ohd.CreateTime >= '$max_time' AND ohd.DevID = '$dev_id' ORDER BY ohd.CreateTime DESC) subquery GROUP BY Partion";
		$list = DBHelper::getList ( $sql );
		foreach ( $list as $key => $value ) {
			DeviceFormatter::getInstance ()->formatDiskInfo ( $list [$key] );
		}
		return $list;
	}
	
	/**
	 * 获取该设备硬盘信息的最晚自检时间
	 *
	 * @param string $dev_id        	
	 * @return string max time of the specified device
	 */
	private function _getMaxTimeofHarddisk($dev_id) {
		$sql = "SELECT max(ohd.CreateTime) as MaxTime FROM " . OAM_HARD_DISK_PARAM . " ohd WHERE ohd.DevID = '$dev_id' LIMIT 1";
		$row = DBHelper::getOne ( $sql );
		return $row ["MaxTime"];
	}
	
	/**
	 * 获取设备物理信息
	 *
	 * @param string $dev_id        	
	 * @return array <string, <string, mixed>>
	 */
	protected function _getPhysicInfo($dev_id, $bite_time) {
		return array ();
	}
	
	/**
	 * 获取设备状态信息
	 *
	 * @param string $dev_id        	
	 * @return array:
	 */
	protected function _getStatusInfo($dev_id, $bite_time) {
		return array ();
	}
	
	/**
	 * 获取图形监控信息
	 *
	 * @param string $dev_id        	
	 * @return mixed
	 */
	protected function _getMonitorInfo($dev_id) {
		$device = $this->getDevice ( $dev_id );
		
		include_once 'lib/DAO/CactiDAO.php';
		$cactiDAO = new CactiDAO ();
		
		$dev_type = $device ["DevType"];
		$is_support = $cactiDAO->isSupport ( $dev_type );
		if ($is_support) {
			$time_periods = $cactiDAO->getTimePeriods ( $dev_type );
			$graph_types = $cactiDAO->getGraphTypes ( $dev_type );
		}
		
		$result = array (
				"is_support" => $is_support,
				"time_periods" => $time_periods,
				"graph_types" => $graph_types 
		);
		return $result;
	}
}

/**
 * CMTDevice： CMT设备
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class CMTDevice extends DeviceAdapter {
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see DeviceAdapter::_getPhysicInfo()
	 */
	protected function _getPhysicInfo($dev_id, $bite_time) {
		$os_list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_OS, $bite_time );
		// $os_info = DeviceFormatter::getInstance ()->formatOsInfo ( $os_list );
		
		$signal_list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_AIRPLANE, $bite_time );
		// $signal_info = DeviceFormatter::getInstance ()->formatAirplaneInfo ( $signal_list );
		
		// $physic_info = array_merge ( $os_info, $signal_info );
		// return $physic_info;
		return DeviceFormatter::getInstance ()->formatList ( array_merge ( $os_list, $signal_list ) );
	}
	
	/**
	 * 获取CMT设备上的信号状态，包括3G、PA、WoW、3G模块IP地址
	 *
	 * @see DeviceAdapter::_getStatusInfo()
	 */
	protected function _getStatusInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_AIRPLANE, $bite_time );
		$status_info = DeviceFormatter::getInstance ()->formatAirplaneInfo ( $list );
		return $status_info;
	}
}

/**
 * ServerDevice: Server
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class ServerDevice extends DeviceAdapter {
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see DeviceAdapter::_getPhysicInfo()
	 */
	protected function _getPhysicInfo($dev_id, $bite_time) {
		$os_list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_OS, $bite_time );
		// $os_info = DeviceFormatter::getInstance ()->formatOsInfo ( $os_list );
		// return $os_info;
		return DeviceFormatter::getInstance ()->formatList ( $os_list );
	}
}

/**
 * ADBDevice: ADB
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class ADBDevice extends DeviceAdapter {
}

/**
 * APsDevice: APs
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class APsDevice extends DeviceAdapter {
	
	/**
	 * 获取AP列表信息
	 *
	 * @see DeviceAdapter::_getSubDeviceList()
	 */
	protected function _getSubDeviceList() {
		$sql = "SELECT * FROM " . OAM_AP_STATUS;
		$list = DBHelper::getList ( $sql );
		$ap_list = DeviceFormatter::getInstance ()->formatAPList ( $list );
		return $ap_list;
	}
	
	/**
	 * 获取APs物理信息
	 *
	 * @see DeviceAdapter::_getPhysicInfo()
	 */
	protected function _getPhysicInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_ACINFO, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}
	
	/**
	 * 获取APs状态信息
	 *
	 * @see DeviceAdapter::_getStatusInfo()
	 */
	protected function _getStatusInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_ACINFO, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatACInfoDetail ( $list );
		return $result;
	}
	public function getAPList() {
		return $this->_getSubDeviceList ();
	}
}

/**
 * CPEDevice: CPE
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class CPEDevice extends DeviceAdapter {
	
	/**
	 * 获取CPE物理信息
	 *
	 * @see DeviceAdapter::_getPhysicInfo()
	 */
	protected function _getPhysicInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_APP, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}
	
	/**
	 * 获取CPE状态信息
	 *
	 * @see DeviceAdapter::_getStatusInfo()
	 */
	protected function _getStatusInfo($dev_id, $bite_time) {
		$bite_list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_OS, $bite_time );
		$cpe_list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_CPE, $bite_time );
		$list = array_merge ( $bite_list, $cpe_list );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}
}

/**
 * CAP2KDevice: CAP2000
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class CAP2KDevice extends DeviceAdapter {
	protected function _getPhysicInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_APP, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}
	protected function _getStatusInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_OS, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}

//	protected function _getStatusInfo($dev_id, $bite_time) {
//		$sql = "SELECT DevID FROM oam_device where DevType = 15";
//		$cap_list = DBHelper::getList ( $sql );
//		$max_number = 0;
//		$max_record = Array();
//		foreach($cap_list as $dev)
//		{
//			$list = $this->_getBiteParamValue ( $dev["DevID"], BITE_GROUP_OS, $bite_time );
//			if ($max_number < count($list))
//			{
//				$max_record = $list;
//				$max_number = count($list);
//			}
//		}
//		$result = DeviceFormatter::getInstance ()->formatList ( $max_record );
//		return $result;
//	}
}

/**
 * CAPKontronDevice: CAP Kontron
 *
 * @author Luke Huang 2014-8-18
 *        
 */
class CAPKontronDevice extends DeviceAdapter {
	protected function _getPhysicInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_APP, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}
	protected function _getStatusInfo($dev_id, $bite_time) {
		$list = $this->_getBiteParamValue ( $dev_id, BITE_GROUP_OS, $bite_time );
		$result = DeviceFormatter::getInstance ()->formatList ( $list );
		return $result;
	}
//	protected function _getStatusInfo($dev_id, $bite_time) {
//		$list = $this->_getBiteParamValue_cap2k( $dev_id, $bite_time );
//		$result = DeviceFormatter::getInstance ()->formatList ( $list );
//		return $result;
//	}
}

/**
 * DeviceFormatter: 设备信息的格式化封装类
 *
 * @author Luke Huang 2014-8-19
 *        
 */
class DeviceFormatter {
	private static $_instance;
	private function __construct() {
	}
	
	/**
	 * 覆盖克隆方法，禁用克隆
	 */
	private function __clone() {
	}
	public static function getInstance() {
		if (! (self::$_instance instanceof self)) {
			self::$_instance = new self ();
		}
		return self::$_instance;
	}
	
	/**
	 * 格式化设备信息
	 * 注意：参数必须是引用
	 *
	 * @param array $device
	 *        	设备信息引用
	 */
	public function formatDevice(&$device) {
/*		$device ["NameText"] = $this->_formatDeviceName ( $device ["DevType"], $device ["Name"], $device ["DevPosition"] );
		$device ["IPText"] = $this->_formatIP ( $device ["IPAddress"] );
		$device ["MacText"] = $this->_formatMac ( $device ["DevID"] );
		
		$status = $device ["DevStatus"] == 2;
		$device ["Status"] = $status ? 1 : 0;
		$device ["StatusText"] = $this->_formatOnlineStatus ( $status );
		$device ["Descs"] = Trans::t ( $device ["Descs"] );
		$device ["RegisterDate"] = formatUTCDateTime ( $device ["RegisterDate"] );*/

		$device->NameText = $this->_formatDeviceName ( $device->DevType, $device->Name, $device->DevPosition);
		$device->IPText = $this->_formatIP ( $device ->IPAddress );
		$device->MacText = $this->_formatMac ( $device->DevID);
		$status = $device->DevStatus == 2;
		$device->Status = $status ? 1 : 0;
		$device->StatusText = $this->_formatOnlineStatus ( $status );
		$device ->Descs = $device->Descs ;
		//$device->RegisterDate = formatUTCDateTime ( $device->RegisterDate);
		$device->RegisterDate =$device->RegisterDate;
		return $device;
	}
	
	/**
	 * 格式化硬盘信息
	 * 注意：参数必须是引用
	 *
	 * @param array $disk_info
	 *        	硬盘信息引用
	 */
	public function formatDiskInfo(&$disk_info) {
		$disk_info ["DiskAvail"] = $this->_formatDiskCapacity ( $disk_info ["DiskAvail"] );
		$disk_info ["DiskTotal"] = $this->_formatDiskCapacity ( $disk_info ["DiskTotal"] );
		$disk_info ["DiskPercent"] = $this->_formatPercentage ( $disk_info ["DiskPercent"] );
		return $disk_info;
	}
	
	/**
	 * 格式化应用信息，以应用名称为索引，记录运行状态、运行状态值、运行时间。
	 *
	 * @param array $app_list        	
	 * @return <string, <string, string>>
	 */
	public function formatAppInfo($list) {
		$result = array ();
		foreach ( $list as $key => $value ) {
			switch ($value ["ParamType"]) {
				case PT_RUNNING_STATE :
					$result [$value ["AppName"]] ["state"] = $value ["ParamValue"];
					$result [$value ["AppName"]] ["state_text"] = $this->_formatAppState ( $value ["ParamValue"] );
					break;
				
				case PT_RUNNING_TIME :
					$result [$value ["AppName"]] ["up_time"] = $this->_formatTime ( $value ["ParamValue"] );
					break;
			}
		}
		return $result;
	}
	public function formatOsInfo($list) {
		$result = array ();
		foreach ( $list as $key => $value ) {
			switch ($value ["ParamType"]) {
				case PT_CPU_IDLE : // 空闲CPU
					$result ["cpu_idle"] = $this->_formatPercentage ( $value ["ParamValue"] );
					break;
				
				case PT_MEM_TOTAL : // 总内存
					$mem_total = $value ["ParamValue"];
					$result ["mem_total"] = $this->_formatDiskCapacity ( $value ["ParamValue"] );
					break;
				
				case PT_MEM_FREE : // 空闲内存
					$mem_free = $value ["ParamValue"];
					$result ["mem_free"] = $this->_formatDiskCapacity ( $value ["ParamValue"] );
					break;
				
				case PT_CPU_TEMP : // CPU温度
					$result ["cpu_temp"] = $this->_formatTemperature ( $value ["ParamValue"] );
					break;
				
				case PT_SYS_TEMP : // 系统CPU
					$result ["sys_temp"] = $this->_formatTemperature ( $value ["ParamValue"] );
					break;
			}
		}
		if (! (empty ( $mem_free ) && empty ( $mem_total )) && intval ( $mem_total ) > 0) { // 当内存值正常时，计算百分比
			$result ["mem_percent"] = $this->_formatPercentage ( intval ( $mem_free ) * 100 / intval ( $mem_total ) );
		}
		return $result;
	}
	public function formatAirplaneInfo($list) {
		$result = array ();
		foreach ( $list as $key => $value ) {
			switch ($value ["ParamType"]) {
				case PT_3G_STATUS : // 3G状态
					$result ["3g_status"] = $value ["ParamValue"];
					$result ["3g_status_text"] = $this->_formatSignalState ( $value ["ParamValue"] );
					break;
				
				case PT_CABIN_DOOR_STATUS : // 舱门状态
				case PT_WOW_STATUS : // WoW
					$result ["door_status"] = $value ["ParamValue"];
					$result ["door_status_text"] = $this->_formatSignalState ( $value ["ParamValue"] );
					$result ["wow_status"] = $value ["ParamValue"];
					$result ["wow_status_text"] = $this->_formatSignalState ( $value ["ParamValue"] );
					break;
				
				case PT_PA_STATUS : // PA
					$result ["pa_status"] = $value ["ParamValue"];
					$result ["pa_status_text"] = $this->_formatSignalState ( $value ["ParamValue"] );
					break;
				
				case PT_3G_IP :
					$result ["3g_ip"] = $this->_formatIP ( $value ["ParamValue"] );
					break;
			}
		}
		return $result;
	}
	public function formatAPList(&$list) {
		foreach ( $list as $key => $value ) {
			$list [$key] ["NameText"] = $value ["Name"];
			// OperationalState: 1--启用 2--禁用
			// AvailStatus： 3--可接入 2--禁止接入
			$status = $value ["OperationalState"] == 1 && $value ["AvailStatus"] == 3;
			$list [$key] ['Status'] = $status ? 1 : 0;
			$list [$key] ['StatusText'] = $this->_formatOnlineStatus ( $status );
			$list [$key] ['IPText'] = $value ["IPAddress"];
			$list [$key] ['MacText'] = $value ["Mac"];
		}
		return $list;
	}
	public function formatACInfoDetail($list) {
		$result = array ();
		foreach ( $list as $key => $value ) {
			switch ($value ["ParamType"]) {
				case PT_AC_NAME : // AC名称
					$result ["ac_name"] = $value ["ParamValue"];
					break;
				
				case PT_AC_MODEL : // AC型号
					$result ["ac_model"] = $value ["ParamValue"];
					break;
				
				case PT_AC_VERSION : // AC版本
					$result ["ac_version"] = $value ["ParamValue"];
					break;
				
				case PT_UP_TIME : // AC上线时长
					$result ["up_time"] = $this->formatParamValue ( $value ["ParamType"], $value ["ParamValue"] );
					break;
				
				case PT_AP_ONLINE : // 在线AP数量
					$result ["ap_online"] = $value ["ParamValue"];
					break;
				
				case PT_AP_OFFLINE : // 离线AP数量
					$result ["ap_offline"] = $value ["ParamValue"];
					break;
				
				case PT_USER_WLAN : // 无线用户数
					$result ["user_wlan"] = $value ["ParamValue"];
					break;
				
				case PT_USER_LAN : // 有线用户数
					$result ["user_lan"] = $value ["ParamValue"];
					break;
				
				case PT_ALARM_TOTAL : // WiFi总告警数
					$result ["alarm_total"] = $value ["ParamValue"];
					break;
				
				case PT_ALARM_CRIT : // WiFi关键告警数
					$result ["alarm_crit"] = $value ["ParamValue"];
					break;
				
				case PT_ALARM_MAJOR : // WiFi重要告警数
					$result ["alarm_major"] = $value ["ParamValue"];
					break;
				
				case PT_ALARM_MINOR : // WiFi次要告警数
					$result ["alarm_minor"] = $value ["ParamValue"];
					break;
				
				case PT_WLAN_RECV : // WiFi总接收流
					$result ["wlan_recv"] = $this->formatParamValue ( $value ["ParamType"], $value ["ParamValue"] );
					break;
				
				case PT_WLAN_SEND : // WiFi总发送流
					$result ["wlan_send"] = $this->formatParamValue ( $value ["ParamType"], $value ["ParamValue"] );
					break;
				
				default :
					break;
			}
		}
		return $result;
	}
	public function formatCPEBasicInfo($list) {
		return $list;
	}
	public function formatCPEDetailInfo($list) {
		$result = array ();
		foreach ( $list as $key => $value ) {
			switch ($value ["ParamType"]) {
				case PT_AUB_LOAD_VER : //
					break;
				default :
					break;
			}
		}
		return $result;
	}
	
	/**
	 * 以列表方式进行格式化输出，该方法用于统一的参数扩展输出，主要用于参数个数不确定的情况。
	 * 结果数组中以参数类型作为索引，label表示参数名称，value表示参数值。
	 *
	 * @param array $list        	
	 * @return <integer, <'label'=>string, 'value'=>string>>
	 */
	public function formatList($list) {
		// 要屏蔽的参数名单
		$deny_list = $this->_getDenyList ();
		
		$result = array ();
		foreach ( $list as $key => $value ) {
			// 如果参数在屏蔽名单内，则不记录
			if (in_array ( $value ["ParamType"], $deny_list )) {
				continue;
			}
			// 参数名称
			$result [$value ["ParamType"]] ['label'] = Trans::t ( $value ["ParamName"] );
			// 参数值
			$result [$value ["ParamType"]] ['value'] = $this->formatParamValue ( $value ["ParamType"], $value ["ParamValue"] );
		}
		return $result;
	}
	
	/**
	 * 根据参数类型，对参数值进行封装，主要用于运行日志页面显示和数据导出。
	 *
	 * @param integer $param_type        	
	 * @param string $param_value        	
	 * @return string
	 */
	public function formatParamValue($param_type, $param_value) {
		switch ($param_type) {
			case PT_RUNNING_STATE : // 应用运行状态
				$result = $this->_formatAppState ( $param_value );
				break;
			
			case PT_RUNNING_TIME :
			case PT_CPE_UPTIME :
				$result = $this->_formatTime ( $param_value );
				break;
			
			case PT_CPU_IDLE :
				$result = $this->_formatPercentage ( $param_value );
				break;
			
			case PT_MEM_TOTAL :
			case PT_MEM_FREE :
				$result = $this->_formatDiskCapacity ( $param_value );
				break;
			
			case PT_CPU_TEMP :
			case PT_SYS_TEMP :
				$result = $this->_formatTemperature ( $param_value );
				break;
			
			case PT_UP_TIME :
				$result = $this->_formatTime ( $param_value / 100 );
				break;
			
			case PT_3G_STATUS :
			case PT_CABIN_DOOR_STATUS :
			case PT_PA_STATUS :
			case PT_CPE_STATUS :
				$result = $this->_formatSignalState ( $param_value );
				break;
			
			case PT_3G_IP :
			case PT_CPE_IP :
			case PT_CPE_PUBLIC_IP :
				$result = $this->_formatIP ( $param_value );
				break;
			
			case PT_CPE_MAC :
				$result = $this->_formatMac ( $param_value );
				break;
			
			case PT_WLAN_RECV :
			case PT_WLAN_SEND :
				$result = $this->_formatDiskCapacity ( $param_value, 1, 'b' );
				break;
			
			case PT_MEM_SWAP_ALARM : // 交换内存告警
				$result = $this->_formatSwapAlarmFlag ( intval ( $param_value ) );
				break;
			
			case PT_AUB_LOAD_VER :
			case PT_RFU_LOAD_VER :
			case PT_RFU_RF_CALIB :
				$result = $this->_formatCPEBiteResult ( intval ( $param_value ) );
				break;
			
			case PT_CPE_STATUS : // CPE空地状态
			case PT_CONN_STATUS : // CAP网络状态
				$result = $this->_formatOnlineStatus ( intval ( $param_value ) );
				break;
			
			case PT_RECV_BYTES :
			case PT_SEND_BYTES :
				$result = $this->_formatDiskCapacity ( $param_value, 1 );
				break;
			
			default :
				$result = $param_value;
				break;
		}
		
		return $result;
	}
	private function _formatAppState($value) {
		$state = "N/A";
		if (trim ( $value ) == '0') {
			$state = Trans::t ( "已停止" );
		} elseif (trim ( $value ) == '1') {
			$state = Trans::t ( "运行中" );
		}
		return $state;
	}
	
	/**
	 * 格式化运行时间，单位为s
	 *
	 * @param integer $value        	
	 * @return string
	 */
	private function _formatTime($value) {
		$result = "";
		$seconds = intval ( $value );
		if ($seconds > 0) {
			$day = floor ( $seconds / 86400 ); // 1day
			$seconds %= 86400;
			$hour = floor ( $seconds / 3600 ); // 1hour
			$seconds %= 3600;
			$minute = floor ( $seconds / 60 ); // 1min
			$seconds %= 60;
			$second = $seconds; // 1s
			
			if ($day > 0) {
				$result .= $day . "d ";
			}
			if ($hour > 0) {
				$result .= $hour . "h ";
			}
			if ($minute > 0) {
				$result .= $minute . "m ";
			}
			if ($second > 0) {
				$result .= $second . "s ";
			}
		} else {
			$result = "N/A";
		}
		return $result;
	}
	private function _formatPercentage($value) {
		if (empty ( $value )) {
			$value = "1%";
		} else if (intval ( $value ) <= 100) {
			$value = $value . "%";
		} else { // 当snmp进程被杀死后，数据可能溢出
			$value = "N/A";
		}
		return $value;
	}
	
	/**
	 * 格式化流量、空间相关的参数值
	 * 1.如果是硬盘空间，使用默认参数，块大小为KB
	 * 2.如果是流量带宽，使用$denominator = 1， $unit = 'b'
	 * 3.如果是网络统计，使用$denominator = 1， $unit = 'B'
	 *
	 * @param string $value
	 *        	参数值
	 * @param integer $denominator
	 *        	块大小
	 * @param string $unit
	 *        	单位
	 * @return string 格式化的输出值
	 */
	private function _formatDiskCapacity($value, $denominator = 1024, $unit = 'B') {
		$result = "";
		$value = floatval ( $value ) * $denominator;
		if ($value >= 1073741824) { // 1024*1024*1024
			$result = sprintf ( "%.2f G%s", $value / 1073741824, $unit );
		} else if ($value >= 1048576) {
			$result = sprintf ( "%.2f M%s", $value / 1048576, $unit );
		} else if ($value >= 1024) { // 1024*1024
			$result = sprintf ( "%.2f K%s", $value / 1024, $unit );
		} else if ($value >= 0) {
			$result = sprintf ( "%.2f %s", $value, $unit );
		}
		return $result;
	}
	private function _formatTemperature($value) {
		$value = intval ( $value ) . " ℃";
		return $value;
	}
	private function _formatSignalState($value) {
		if (trim ( $value ) == '1') {
			$state = Trans::t ( "开启" );
		} elseif (trim ( $value ) == '0') {
			$state = Trans::t ( "关闭" );
		} elseif (empty ( $state )) {
			$state = "N/A";
		} else {
			$state = Trans::t ( "超时" );
		}
		return $state;
	}
	private function _formatSwapAlarmFlag($value) {
		if (empty ( $value )) {
			$text = Trans::t ( "有" );
		} else {
			$text = Trans::t ( "无" );
		}
		return $text;
	}
	private function _formatCPEBiteResult($value) {
		switch ($value) {
			case CPE_BITE_NOT_YET :
				$text = Trans::t ( "尚未自检" );
				break;
			
			case CPE_BITE_IN_PROC :
				$text = Trans::t ( "正在自检" );
				break;
			
			case CPE_BITE_FAILED :
				$text = Trans::t ( "自检失败" );
				break;
			
			case CPE_BITE_SUCCESS :
				$text = Trans::t ( "自检成功" );
				break;
			
			default :
				break;
		}
		return $text;
	}
	private function _formatDeviceName($dev_type, $dev_name, $dev_position) {
		switch ($dev_type) {
			case Consts::DEV_TYPE_CAP :
				$name = sprintf ( "%s-%s", $dev_name, str_replace ( "0-ap-", "", $dev_position ) );
				break;
			
			default :
				$name = $dev_name; // sprintf("%s (%s)",$device["Name"], $device["DevPosition"]);
				break;
		}
		return $name;
	}
	private function _formatOnlineStatus($status) {
		//return $status ? Trans::t ( "在线" ) : Trans::t ( "离线" );
		return $status ? "在线"  :  "离线" ;
	}
	private function _formatIP($ip) {
		if (session('cmt_user_type') != "super") {
			$count = 4;
			$pieces = explode ( '.', $ip, $count );
			if (count ( $pieces ) == $count) {
				$ip = sprintf ( "%s.%s.*.*", $pieces [0], $pieces [1] );
			}
		}
		return $ip;
	}
	private function _formatMac($mac) {
		if (session('cmt_user_type')!= "super") {
			$count = 6;
			$pieces = explode ( ':', $mac, $count );
			if (count ( $pieces ) == $count) {
				$mac = sprintf ( "%s:%s:%s:*:*:*", $pieces [0], $pieces [1], $pieces [2] );
			}
		}
		return $mac;
	}
	
	/**
	 * 获取屏蔽显示的参数类型列表
	 *
	 * @return array:<integer> 屏蔽显示的参数类型
	 */
	private function _getDenyList() {
		$list = array ();
		array_push ( $list, PT_3G_STATUS );
		array_push ( $list, PT_WOW_STATUS );
		array_push ( $list, PT_PA_STATUS );
		
		array_push ( $list, PT_MAX_AP_LIMIT );
		array_push ( $list, PT_MAX_CLIENT_LIMIT );
		array_push ( $list, PT_INSTALLED_LICENSES );
		array_push ( $list, PT_IN_USE_LICENSES );
		
		// array_push ( $list, PT_USER_WLAN_2DOT4G );
		// array_push ( $list, PT_USER_WLAN_5G );
		
		array_push ( $list, PT_ROGUE_APS );
		array_push ( $list, PT_ROGUE_STATIONS );
		array_push ( $list, PT_ROGUE_UNKNOWN_DEV );
		array_push ( $list, PT_CLEAR_ESS_PROFILE );
		array_push ( $list, PT_SECURE_ESS_PROFILE );
		array_push ( $list, PT_CAPTIVE_PORTAL_ESS_PROFILE );
		return $list;
	}
}
?>
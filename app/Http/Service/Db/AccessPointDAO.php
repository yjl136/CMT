<?php
namespace App\Http\Service\Db;
use App\Http\Service\Consts;

class AccessPointDAO extends BaseDAO {

	public function getAPList() {
		$sql = "SELECT * FROM " . Consts::OAM_AP_STATUS;
		return DBHelper::getList ( $sql );
	}

	public function getAP($ip) {
		$sql = "SELECT * FROM " . Consts::OMA_AP_STATUS . " WHERE IPAddress = '$ip' LIMIT 1";
		return DBHelper::getOne ( $sql );
	}

	public function updateAP($ip, $params) {
		$data = array();
		foreach($params as $key => $value){
			array_push($data, sprintf(" %s = '%s' ", $key, $value));
		}
		$sql = "UPDATE ".OAM_AP_STATUS." SET ".implode(',', $data)." WHERE IPAddress = '$ip'";
		return DBHelper::saveOrUpdate($sql);
	}

	public function deleteAP($ip) {
		$sql = "DELETE FROM " . OAM_AP_STATUS . " WHERE IPAddress = '$ip'";
		return DBHelper::delete ( $sql );
	}
}
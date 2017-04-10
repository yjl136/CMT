<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/8
 * Time: 10:19
 */

namespace App\Http\Service\System;
use App\Http\Service\Base\BaseService;
use App\Http\Service\Consts;
use App\Http\Service\Db\ExtDeviceDAO;
use App\Http\Service\Log\Log;
use App\Http\Service\Tcp\CommandHelper;
use App\Http\Service\Utils\ConvertHelper;

class ExtDeviceService extends BaseService
{
    private $deviceDAO;

    public function __construct() {
        $this->deviceDAO = new ExtDeviceDAO ();
    }

    public function getDeviceList($page) {
        return $this->deviceDAO->getDeviceList ( $page );
    }

    public function getAllDevice() {
        $dev_list = $this->deviceDAO->getAllDevice ();

        if (AP_MODE_DEFAULT == AP_MODE_APS) {
            include_once 'lib/Service/StatusService.php';
            $adapter = new WiFiAdapter ();
            $ap_list = $adapter->getAPList ();
            if (is_array ( $ap_list )) {
                $dev_list = array_merge ( $dev_list, $ap_list );
            }
        }
        return $dev_list;
    }

    public function getDeviceCategoryList($all = false) {
        $cate_list = $this->deviceDAO->getDeviceCategory ();
        if ($all) {
            $head = array (
                "ID" => DEV_TYPE_ALL,
                "Name" => Trans::t ( "全部" )
            );
            // 将head插入到第一个位置
            array_unshift ( $cate_list, $head );
        }
        return $cate_list;
    }

    public function getDevice($dev_id) {
        return $this->deviceDAO->getDevice ( $dev_id );
    }

    public function getDeviceListByDevType($dev_type, $limit_one = false) {
        return $this->deviceDAO->getDeviceListByDevType ( $dev_type, $limit_one );
    }

    public function getDeviceDetailByType($dev_id, $type, $bite_time) {
        return $this->deviceDAO->getDeviceDetail ( $dev_id, $type, $bite_time );
    }

    public function getDeviceDetail($dev_id, $bite_time = '') {
        $result [DEV_INFO_DEV] = $this->deviceDAO->getDeviceDetail ( $dev_id, DEV_INFO_DEV, $bite_time );
        $result [DEV_INFO_SUB_DEV] = $this->deviceDAO->getDeviceDetail ( $dev_id, DEV_INFO_SUB_DEV, $bite_time );
        $result [DEV_INFO_APP] = $this->deviceDAO->getDeviceDetail ( $dev_id, DEV_INFO_APP, $bite_time );
        $result [DEV_INFO_HARDDISK] = $this->deviceDAO->getDeviceDetail ( $dev_id, DEV_INFO_HARDDISK, $bite_time );
        $result [DEV_INFO_PHYSIC] = $this->deviceDAO->getDeviceDetail ( $dev_id, DEV_INFO_PHYSIC, $bite_time );
        $result [DEV_INFO_STATUS] = $this->deviceDAO->getDeviceDetail ( $dev_id, DEV_INFO_STATUS, $bite_time );
        return $result;
    }

    public function getParamMap() {
        return $this->deviceDAO->getParamMap ();
    }

    public function getMonitorParamValueList($page, $params) {
        return $this->deviceDAO->getMonitorParamValueList ( $page, $params );
    }
    public function bite($dev_id) {
        $device = $this->deviceDAO->getDevice ( $dev_id );
        if(!$device[0]->Status){
            $result ["code"] = Consts::CODE_FAILURE;
            // $result ["content"] = Trans::t("设备离线，无法自检！");
            $result ["content"] = trans("maintain.content");
            return $result;
        }

        $dev_type = $device[0]->DevType;
        switch ($dev_type) {
            case Consts::TARGET_CMT :
                $group_id = Consts::BITE_GROUP_APP | Consts::BITE_GROUP_OS | Consts::BITE_GROUP_AIRPLANE | Consts::BITE_GROUP_HARDDISK;
                break;

            case Consts::TARGET_SERVER :
                $group_id = Consts::BITE_GROUP_APP | Consts::BITE_GROUP_OS | Consts::BITE_GROUP_HARDDISK;
                break;

            case Consts::TARGET_APS :
                $group_id = Consts::BITE_GROUP_ACINFO | Consts::BITE_GROUP_APINFO;
                break;
            case Consts::TARGET_CPE :
                $group_id = Consts::BITE_GROUP_OS | Consts::BITE_GROUP_CPE;
                break;

            case Consts::DEV_TYPE_CAP :
                //$group_id = BITE_GROUP_APP | BITE_GROUP_OS;
                $group_id = Consts::BITE_GROUP_OS;
                break;

            default :
                $group_id = Consts::BITE_GROUP_APP | Consts::BITE_GROUP_OS | Consts::BITE_GROUP_AIRPLANE | Consts::BITE_GROUP_ACINFO | Consts::BITE_GROUP_HARDDISK | Consts::BITE_GROUP_APINFO;
                if (defined ( "PLUGIN_CPE" ) && Consts::PLUGIN_CPE) {
                    $group_id |= Consts::BITE_GROUP_CPE;
                }
                break;
        }

        $result = $this->_sendBiteCommand ( $dev_type, $group_id, $device[0]->DevPosition);
        return $result;
    }

    private function _sendBiteCommand($dev_type, $group_id, $pos = '') {
        $params = array (
            "groupId" => $group_id
        );
        if (! empty ( $pos )) {
            $params ["pos"] = $pos;
        }
        $result = CommandHelper::sendCommand ( Consts::CMD_BITE, $dev_type, $params );
        $result ["error_code"] = $result ["code"];
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $result ["biteTime"] = $result ["content"] ["biteTime"];
                $result ["code"] = Consts::CODE_SUCCESS;
                break;
            default :
                Log::write ( "BITE failed." . sprintf ( "CODE[%s]", $result ["code"] ), Log::ERROR );
                $result ["content"] = trans("maintain.bitefailed") ;
                break;
        }
        return $result;
    }
}
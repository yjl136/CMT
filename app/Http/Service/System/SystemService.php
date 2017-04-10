<?php
namespace App\Http\Service\System;
use App\Http\Service\Base\BaseService;
use App\Http\Service\Consts;
use App\Http\Service\Tcp\CommandHelper;

class SystemService extends BaseService
{

    public function getVersionList($page = 1) {
        // 查询总数的sql
        $count_sql = "SELECT COUNT(ID) FROM " . CMT_VERSION . " WHERE DevType in (" . $this->getAvailCateList () . ")";
        // 查询数据的sql
        $query_sql = "SELECT cv.DevType, cv.DevPosition, cv.DevNumber, cv.CurVersion, cv.CurSysVersion, cv.CurAppVersion, cv.DevSeq,cv.DevModel, odc.Name FROM " . CMT_VERSION . " cv INNER JOIN " . OAM_DEVICE_CATEGORY . " odc ON cv.DevType = odc.ID AND cv.DevType in (" . $this->getAvailCateList () . ") ORDER BY cv.DevType";
        // 查询一页数据
        $pager = $this->getPageList ( $count_sql, $query_sql, $page, DEFAULT_ROWS_PER_PAGE, "formatVersionList" );
        return $pager;
    }

    public function getThirdVersionList($page = 1) {
        // 查询总数的sql
        $count_sql = "SELECT COUNT(id) FROM cmt_thirdparty_manager";
        // 查询数据的sql
        $query_sql = "SELECT * FROM cmt_thirdparty_manager";
        // 查询一页数据
        $pager = $this->getPageList ( $count_sql, $query_sql, $page, DEFAULT_ROWS_PER_PAGE, "formatVersionList" );
        return $pager;
    }

    public function formatVersionList($list, $params) {
        foreach ( $list as $key => $value ) {
            $list [$key] ["NameText"] = Formatter::formatDeviceName ( $list [$key] ["DevType"], $list [$key] ["Name"], $list [$key] ["DevPosition"] );
        }
        return $list;
    }

    public function getPlane() {
        $sql = "SELECT * FROM " . OAM_AIRPLANE . " LIMIT 1";
        return DBHelper::getOne ( $sql );
    }

    public function queryWifiMode() {
        $result = CommandHelper::sendCommand ( Consts::CMD_QUERY_TEST_MODE, Consts::TARGET_SERVER );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                if ($result ["content"] ["mode"] == '1') {
                    $result ["code"] = "open";
                    $result ["remainSeconds"] = intval ( $result ["content"] ["remainSeconds"] );
                } else {
                    $result ["code"] = "close";
                }
                break;

            case Consts::CODE_SOCKET_ERROR :
                $result ["content"] = Trans::t ( "查询WiFi控制模式失败！" ) . Trans::t ( "连接通道错误！" );
                break;

            default :
                $result ["code"] = "error";
                $result ["content"] = CommandHelper::getErrorMsg ( $result ["code"] );
                break;
        }
        // TODO 调试代码
       /* if (CFG_DEBUG_MODE) {
            $result ["code"] = "open";
            $result ["remainSeconds"] = 1690;
        }*/
        return $result;
    }

    public function switchWifiMode($mode, $responsable = true) {
        $result = CommandHelper::sendCommand ( Consts::CMD_SET_TEST_MODE, Consts::TARGET_SERVER, array (
            "mode" => $mode
        ), $responsable );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                if ($responsable) {
                    $logMsg = sprintf ( "Switch WiFi control mode to [%s Mode]", $mode ? "Manual" : "Auto" );
                    $this->logOperation ( $logMsg );
                }
                $result ["content"] ="切换WiFi控制模式成功！";
                break;
            case Consts::CODE_EXEC_FAILURE :
                $result ["content"] ="切换WiFi控制模式失败！";
                break;
            case Consts::CODE_SOCKET_ERROR :
                $result ["content"] ="切换WiFi控制模式失败！" . "连接通道错误！" ;
                break;
            default :
                $result ["code"] = "error";
                $result ["content"] = CommandHelper::getErrorMsg ( $result ["code"] );
                break;
        }
        return $result;
    }
    public function switch4GMode($mode){
        $result = CommandHelper::sendCommand ( Consts::CMD_SWITCH_4G, Consts::TARGET_SERVER, array ("mode" => $mode) );
        switch($result ["code"]){
            case Consts::CODE_EXEC_SUCCESS :
                $result ["code"] = Consts::CODE_SUCCESS;
                $result ["content"] ="切换4G控制模式成功！";
                break;
            case Consts::CODE_EXEC_FAILURE :
                $result ["code"] = Consts::CODE_FAILURE;
                $result ["content"] ="切换4G控制模式失败！";
                break;
            case Consts::CODE_SOCKET_ERROR :
                $result ["content"] ="切换4G控制模式失败！" . "连接通道错误！" ;
                break;
            default:
                $result ["code"] = "error";
                $result ["content"] = CommandHelper::getErrorMsg ( $result ["code"] );
                break;
        }
        return $result;
    }
    public function queryWifi() {
        $service = new AccessPointService ();
        $list = $service->getAPList ();
        return $list;
    }

    public function switchWifi($mode) {
        $result = CommandHelper::sendCommand ( Consts::CMD_SET_WIFI, Consts::TARGET_SERVER, array (
            "mode" => $mode
        ) );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $logMsg = $mode ? "Open WiFi manually" : "Close WiFi manually";
                $this->logOperation ( $logMsg );
                break;
            case Consts::CODE_EXEC_FAILURE :
               // $result ["content"] = Trans::t ( "切换WiFi失败！" );
                $result ["content"] = "切换WiFi失败！" ;
                break;
            case Consts::CODE_SOCKET_ERROR :
                //$result ["content"] = Trans::t ( "切换WiFi失败！" ) . Trans::t ( "连接通道错误！" );
                $result ["content"] = "连接通道错误！";
                break;
            default :
                $result ["content"] = CommandHelper::getErrorMsg ( $result ["code"] );
                break;
        }
        return $result;
    }
    public function wifiSwitch($mode) {
        $result = CommandHelper::sendCommand ( Consts::CMD_SET_WIFI_switch, Consts::TARGET_SERVER, array (
            "mode" => $mode
        ) );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $logMsg = $mode ? "Open WiFi manually" : "Close WiFi manually";
                $this->logOperation ( $logMsg );
                break;
            case Consts::CODE_EXEC_FAILURE :
                // $result ["content"] = Trans::t ( "切换WiFi失败！" );
                $result ["content"] = "切换WiFi失败！" ;
                break;
            case Consts::CODE_SOCKET_ERROR :
                //$result ["content"] = Trans::t ( "切换WiFi失败！" ) . Trans::t ( "连接通道错误！" );
                $result ["content"] = "连接通道错误！";
                break;
            default :
                $result ["content"] = CommandHelper::getErrorMsg ( $result ["code"] );
                break;
        }
        return $result;
    }

    public function switchAP($positionID, $mode) {
        // 由于信令可能接收到其他信令的回复，导致显示"未知错误[-2]"，此处改成不接收回复，即发送后不管执行是否成功。
        $result = CommandHelper::sendCommand ( Consts::CMD_SET_AP_POWER, Consts::TARGET_SERVER, array (
            "mode" => $mode,
            "site" => $positionID
        ), true );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                 $logMsg = sprintf ( "Power %s AP[CAP-%s]", $mode ? "on" : "off", $positionID );
                 $this->logOperation ( $logMsg );
                break;

            case Consts::CODE_EXEC_FAILURE :
                $result ["content"] = Trans::t ( "切换AP电源失败！" );
                break;

            case Consts::CODE_SOCKET_ERROR :
                $result ["content"] = Trans::t ( "切换AP电源失败！" ) . Trans::t ( "连接通道错误！" );
                break;
            default :
                $result ["content"] = CommandHelper::getErrorMsg ( $result ["code"] );
                break;
        }
        return $result;
    }

    public function logSwitchAP($positionID, $mode, $code) {
        $log_msg = sprintf ( "Power %s AP [CAP-%s] ", $mode ? "on" : "off", $positionID );
        if ($code == "success") {
            $log_msg .= "successfully";
        } else if ($code == "timeout") {
            $log_msg .= "timeout";
        } else {
            $log_msg .= "failed";
        }

        return $this->logOperation ( $log_msg );
    }

    public function logSwitchATG($mode, $code) {
        $log_msg = sprintf ( "Power %s CPE ", $mode ? "on" : "off" );
        if ($code == "success") {
            $log_msg .= "successfully";
        } else if ($code == "timeout") {
            $log_msg .= "timeout";
        } else {
            $log_msg .= "failed";
        }

        return $this->logOperation ( $log_msg );
    }

    public function resetFactory() {
        $result = CommandHelper::sendCommand ( Consts::CMD_RESET, Consts::TARGET_SERVER );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $result ["code"] = "success";
                break;

            case Consts::CODE_EXEC_FAILURE :
                $result ["code"] = "failure";
                break;

            case Consts::CODE_SOCKET_ERROR :
                $result ["code"] = "socket_error";
                break;
        }
        return $result;
    }
}
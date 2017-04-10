<?php

namespace App\Http\Service\Update;

use App\Http\Service\Consts;
use App\Http\Service\Log\Log;
use App\Http\Service\Tcp\CommandHelper;
use App\Http\Service\Db\DBHelper;
use Illuminate\Support\Facades\DB;

class DeviceUpdateService extends SystemUpdateService {

    public function checkVersion() {
        // 获取当前版本信息
        $this->_updateCurrentVersion ();
        // 同步更新包版本信息到数据库
        $this->_updatePackageVersion ( Consts::CURRENT_VERSION_SRC . Consts::VERSION_CFG_FILE );

        $result ["code"] = Consts::CODE_SUCCESS;
        return $result;
    }

    protected function _updateCurrentVersion() {
        $target_list = array (
            Consts::TARGET_SERVER
        );

        if (defined ( "PLUGIN_CMT" ) && PLUGIN_CMT) {
            array_push ( $target_list, Consts::TARGET_CMT );
        }

        if (defined ( "PLUGIN_ADB" ) && PLUGIN_ADB) {
            array_push ( $target_list, Consts::TARGET_ADB );
        }

        foreach ( $target_list as $target ) {
            $result = CommandHelper::sendCommand ( Consts::CMD_DEVICE_VERSION, $target, "ALL:ALL" );
            if ($result ["code"] == Consts::CODE_EXEC_SUCCESS) {
                $dev_num = $result ["content"] ["id"];
                $version = $result ["content"] ["version"];
                $sys_version = $result ["content"] ["sys_version"];
                $app_version = $result ["content"] ["app_version"];
                // 根据件号更新版本信息
                $sql = "UPDATE " . Consts::CMT_VERSION . " SET CurVersion = '$version', CurSysVersion = '$sys_version', CurAppVersion = '$app_version' WHERE DevNumber = '$dev_num'";
               //DBHelper::saveOrUpdate ( $sql );
                DB::update($sql);
            }
        }
    }

    public function start($target) {
        return $this->_start ( Consts::CMD_START_SYS_UPDATE, $target );
    }

    public function queryProgress($target) {
        return $this->_queryProgress ( $target, Consts::UPDATE_QUERY_ITEM_SYS, "progressCallBack" );
    }

    public function progressCallBack($result) {
        if ($result ["code"] == Consts::CODE_FAILURE) {
            Log::write ( sprintf ( "*******device update failed for the reason: %s", $result ["reason"] ), Log::ERROR );
           // $this->_logOperation ( sprintf ( "Device update failed for the reason: %s", $result ["reason"] ) );
        } else if ($result ["progress"] == 100) {
            Log::write ( sprintf ( "*******device update success" ), Log::INFO );
           // $this->_logOperation ( "Device update success" );
        } else {
            Log::write ( sprintf ( "*******device update progress: %s%%", $result ["progress"] ), Log::INFO );
        }
    }
}

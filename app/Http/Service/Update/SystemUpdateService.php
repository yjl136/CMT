<?php
namespace App\Http\Service\Update;
use App\Http\Service\Consts;
use App\Http\Service\Db\DBHelper;
use App\Http\Service\Log\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Service\Base\BaseUpdateService;
class SystemUpdateService extends BaseUpdateService {

    public function checkVersion() {
        return $this->_checkVersion ( Consts::UPDATE_QUERY_ITEM_SYS, "checkVersionCallback" );
    }

    public function checkVersionCallback($result) {
        if ($result ["code"] == Consts::CODE_NEW_PACKAGE) {
            $this->_updatePackageVersion ( Consts::UPDATE_SRC . Consts::VERSION_CFG_FILE );
        }
    }

    public function queryVersion() {
        $target_list = array (
            Consts::TARGET_SERVER
        );
        $sql = "SELECT odc.Name, cv.DevType, cv.CurVersion, cv.PkgVersion FROM " . Consts::CMT_VERSION . " cv INNER JOIN " . Consts::OAM_DEVICE_CATEGORY . " odc ON cv.DevType = odc.ID WHERE odc.ID in (" . implode ( ',', $target_list ) . ")";
        return DB::select($sql);;
    }

    public function start($target) {
        return $this->_start ( Consts::CMD_START_SYS_UPDATE, Consts::TARGET_ALL );
    }

    public function queryProgress($target) {
        return $this->_queryProgress ( $target, Consts::UPDATE_QUERY_ITEM_SYS, "progressCallBack" );
    }

    public function progressCallBack($result) {
        if ($result ["code"] == Consts::CODE_FAILURE) {
            Log::write ( sprintf ( "*******system update failed for the reason: %s", $result ["reason"] ), Log::ERROR );
            //$this->_logOperation ( sprintf ( "System update failed for the reason: %s", $result ["reason"] ) );
        } else if ($result ["progress"] == 100) {
            Log::write ( sprintf ( "*******system update success" ), Log::INFO );
           // $this->_logOperation ( "System update success" );
        } else {
            Log::write ( sprintf ( "*******system update progress: %s%%", $result ["progress"] ), Log::INFO );
        }
    }

    protected function _getPackageVersion($file) {
        $versions = array ();
        if (file_exists ( $file )) {
            $xml = simplexml_load_file ( $file );
            foreach ( $xml->xpath ( "AVOD/COMPONET" ) as $component ) {
                // 强制转换为字符串
                $id = $component->ID . "";
                $version = $component->VERSION . "";
                $versions [$id] = $version;
            }
        }
        return $versions;
    }

    protected function _updatePackageVersion($file) {
        $pkg_version = $this->_getPackageVersion ( $file );
        foreach ( $pkg_version as $dev_num => $version ) {
            // 根据件号更新版本信息
            $sql = "UPDATE " . Consts::CMT_VERSION . " SET PkgVersion = '$version' WHERE DevNumber = '$dev_num'";
           // DBHelper::saveOrUpdate ( $sql );
            DB::update($sql);
        }
    }
}
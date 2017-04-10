<?php
namespace App\Http\Service\Update;
use App\Http\Service\Base\BaseUpdateService;
use App\Http\Service\Consts;
use App\Http\Service\Log\Log;

class PackageUpdateService extends BaseUpdateService {

    public function start($target) {
        // 通过USB更新
        $mode = Consts::COPY_FROM_USB;
        // 更新包版本信息
        $version = $this->_getVersionParam ( $mode );
        // 确认更新信令参数
        $param = array (
            "mode" => $mode,
            "version" => $version
        );
        // 发送确认更新信令
        return $this->_start ( Consts::CMD_CONFIRM_UPDATE, $target, $param );
    }

    public function queryProgress($target) {
        return $this->_queryProgress ( Consts::TARGET_SERVER, Consts::UPDATE_QUERY_ITEM_SYS, "progressCallBack" );
    }

    public function progressCallBack($result) {
        if ($result ["code"] == Consts::CODE_FAILURE) {
            Log::write ( sprintf ( "*******Copy package failed for the reason: %s", $result ["reason"] ), Log::ERROR );
        } else if ($result ["progress"] == 100) {
            Log::write ( sprintf ( "*******Copy package success" ), Log::INFO );
        } else {
            Log::write ( sprintf ( "*******Copy package progress: %s%%", $result ["progress"] ), Log::INFO );
        }
    }

    private function _getVersionParam($mode) {
        switch ($mode) {
            case Consts::COPY_FROM_USB :
                $file = Consts::UPDATE_SRC . Consts::VERSION_CFG_FILE;
                break;

            case Consts::COPY_FROM_SVR :
                $file = Consts::BACKUP_VERSION_SRC . Consts::VERSION_CFG_FILE;
                break;

            default :
                break;
        }
        $version = $this->_getVersionFromFile ( $file );
        return $version;
    }

    private function _getVersionFromFile($file) {
        $xml = simplexml_load_file ( $file );
        foreach ( $xml->xpath ( "AVOD" ) as $node ) {
            $attr = $node->attributes ();
            // 强制转换成字符串
            $version = $attr ["version"] . ""; // AVOD版本信息(大版本号)
        }
        return $version;
    }
}

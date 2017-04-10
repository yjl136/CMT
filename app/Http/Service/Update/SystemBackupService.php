<?php
namespace App\Http\Service\Update;
use App\Http\Service\Consts;
use App\Http\Service\Log\SocketLog;
use App\Http\Service\Tcp\CommandHelper;
use App\Http\Service\Base\BaseUpdateService;
class SystemBackupService extends BaseUpdateService
{

    public function start($target) {
        if ($this->_isExternalDriverExisted ()) {
            $site = $this->_getSite ( Consts::TARGET_SERVER );
            $result = CommandHelper::sendCommand ( Consts::CMD_SYS_BACKUP, Consts::TARGET_SERVER, $site );
            $result ['msg'] = CommandHelper::getErrorMsg ( $result ["code"] );
            SocketLog::log ("Unknown Error From( start())". $result ["code"]);
        } else {
            $result ['msg'] = "未找到外挂硬盘！" ;
        }
        return $result;
    }

    public function queryProgress($target) {
        $site = $this->_getSite ( Consts::TARGET_SERVER );
        $result = CommandHelper::sendCommand ( Consts::CMD_SYS_BACKUP_QUERY, Consts::TARGET_SERVER, $site );
        switch ($result ['code']) {
            case Consts::CODE_BACKUP_SUCCESS :
                $result ['msg'] ="备份成功！" ;
                $this->_logOperation ( "System backup successfully" );
                break;

            case Consts::CODE_BACKUPING :
                $result ['msg'] = "备份中......" ;
                break;

            case Consts::CODE_BACKUP_FAILURE :
                $result ['msg'] ="备份失败！" ;
                $this->_logOperation ( "System backup failed" );
                break;

            case Consts::CODE_BACKUP_NO_DISK :
                $result ['msg'] = "未找到外挂硬盘！" ;
                $result ["reason"] = "external hard drive not found";
                break;

            default :
                $result ["reason"] = sprintf ( "unknown error [code = %s]", $result ["code"] );
                $result ['msg'] = CommandHelper::getErrorMsg ( $result ["code"] );
                SocketLog::log ("Unknown Error From( queryProgress())". $result ["code"]);
                $this->_logOperation ( sprintf ( "System backup failed for reason: %s", $result ["reason"] ) );
                break;
        }
        return $result;
    }

    private function _isExternalDriverExisted() {
        $file = Consts::MEDIA_MULTI_DISKINFO_FILE;
        if (file_exists ( $file )) {
            $xml = simplexml_load_file ( $file );
            $disknums=$xml->xpath ("disknum") ;
            return intval ( "" . array_shift ($disknums)) > 0;
        }
        return false;
    }
}
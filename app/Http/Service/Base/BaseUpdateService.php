<?php
namespace App\Http\Service\Base;

use App\Http\Service\Consts;
use App\Http\Service\Db\BaseDAO;
use App\Http\Service\Log\SocketLog;
use App\Http\Service\Tcp\CommandHelper;

class BaseUpdateService {

    public function __construct() {
    }

    public function checkVersion() {
        return false;
    }

    public function queryVersion() {
        return false;
    }

    public function start($target) {
        return false;
    }

    public function stop() {
        return false;
    }

    public function queryProgress($target) {
        return false;
    }

    public function cleanup() {
        return false;
    }

    protected function _checkVersion($item, $callback = '') {
        $result = CommandHelper::sendCommand ( Consts::CMD_QUERY_UPDATE, Consts::TARGET_SERVER, array (
            "item" => $item
        ) );

        $result ["error_code"] = $result ["code"];

        switch ($result ["code"]) {
            case Consts::CODE_NEW_PACKAGE :
             $result ['msg'] = trans("maintain.new");
                break;

            case Consts::CODE_NO_PACKAGE :
            case Consts::CODE_NO_PKG_INFO :
            $result ['msg'] = trans("maintain.find");
                break;

            case Consts::CODE_SAME_VERSION :
                $result ['msg'] = trans("maintain.same");
                break;

            case Consts::CODE_OLD_VERSION :
                $result ['msg'] = trans("maintain.lastest");
                break;

            case Consts::CODE_CONFIG_ERROR :
                $result ['msg'] = trans("maintain.configerror");
                break;

            case Consts::CODE_UNKNOW_ERROR :
                $result ['msg'] = trans("maintain.unkonwerror");
                break;

            case Consts::CODE_PKG_TOO_BIG :
                $result ['msg'] = trans("maintain.space");
                break;

            case Consts::CODE_NO_PLUGIN_DISK :
                $result ['msg'] = trans("maintain.external");
                break;

            case Consts::CODE_SAME_PKG_UNCOMPLETED :
                $result ['msg'] = trans("maintain.incomplete");
                break;

            default :
                $result ['msg'] = CommandHelper::getErrorMsg ( $result ["code"] );
                SocketLog::log ("Unknown Error From( _checkVersion())". $result ["code"]);
                break;
        }

        // 如果需要对结果进行处理，执行回调函数
        is_callable ( array (
            $this,
            $callback
        ) ) && call_user_func_array ( array (
            $this,
            $callback
        ), array (
            &$result
        ) );
        $result ["code"] = $result ["code"] == Consts::CODE_NEW_PACKAGE ? Consts::CODE_SUCCESS : Consts::CODE_FAILURE;
        return $result;
    }

    protected function _start($cmd, $target, $param = '') {
        empty ( $param ) && $param = $this->_getSite ( $target );
        $result = CommandHelper::sendCommand ( $cmd, $target, $param, false );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $result ["code"] = Consts::CODE_SUCCESS;
                break;
            default :
                $result ["msg"] = trans("maintain.commandfail");
                $result ["code"] = Consts::CODE_FAILURE;
                break;
        }
        return $result;
    }

    protected function _getSite($target) {
        switch ($target) {
            case Consts::TARGET_CMT :
                $site = "0-a";
                break;

            case Consts::TARGET_SERVER :
                $site = "0-b";
                break;

            case Consts::TARGET_ADB :
            default :
                $site = "ALL";
                break;
        }
        return $site;
    }

    protected function _queryProgress($target, $item, $callback = '') {
        $site = $this->_getSite ( $target );
        $params = array (
            "item" => $item,
            "site" => $site
        );

        $result = CommandHelper::sendCommand ( Consts::CMD_QUERY_UDPATE_STATUS, $target, $params );
        $result = $this->_parseProgress ( $result );
        // 如果需要对结果进行处理，执行回调函数
        is_callable ( array (
            $this,
            $callback
        ) ) && call_user_func_array ( array (
            $this,
            $callback
        ), array (
            &$result
        ) );
        return $result;
    }

    protected function _parseProgress($result) {
        if ($result ["code"] == Consts::CODE_EXEC_SUCCESS) {
            switch ($result ["content"] ["status"]) {
                case Consts::CODE_UPDATE_NORMAL :
                    $result ["type"] = intval ( $result ["content"] ["type"] );
                    $result ["progress"] = intval ( $result ["content"] ["progress"] );
                    break;

                case Consts::CODE_UPDATE_ERROR :
                    $result ["msg"] = trans("maintain.upgrade");
                    $result ["reason"] = "no data to upgrade!";
                    break;

                case Consts::CODE_NETWORK_ERROR :
                    $result ["msg"] = trans("maintain.networkerror");
                    $result ["reason"] = "network error!";
                    break;

                case Consts::CODE_GET_FILE_FAIL :
                    //$result ["msg"] = Trans::t ( "获取文件失败！" );
                    $result ["msg"] = trans("maintain.fetch");
                    $result ["reason"] = "get file failed!";
                    break;

                case Consts::CODE_FILE_NOT_FOUND :
                   // $result ["msg"] = Trans::t ( "文件未找到！" );
                    $result ["msg"] = trans("maintain.found");
                    $result ["reason"] = "file not found!";
                    break;

                case Consts::CODE_DB_BACKUP_ERROR :
                   // $result ["msg"] = Trans::t ( "数据库备份失败！" );
                    $result ["msg"] = trans("maintain.dump");
                    $result ["reason"] = "dump database failed!";
                    break;

                case Consts::CODE_DB_UPDATE_ERROR :
                   // $result ["msg"] = Trans::t ( "数据库更新失败！" );
                    $result ["msg"] = trans("maintain.dbupdate");
                    $result ["reason"] = "update database failed!";
                    break;

                case Consts::CODE_VIDEO_TABLE_ERROR :
                   // $result ["msg"] = Trans::t ( "媒体数据表更新错误！" );
                    $result ["msg"] = trans("maintain.mediaupdate");
                    $result ["reason"] = "media tables update failed!";
                    break;

                case Consts::CODE_CFG_FILE_ERROR :
                   // $result ["msg"] = Trans::t ( "配置文件错误！" );
                    $result ["msg"] = trans("maintain.configerror");
                    $result ["reason"] = "config error!";
                    break;

                case Consts::CODE_MD5_ERROR :
                   // $result ["msg"] = Trans::t ( "文件校验失败！" );
                    $result ["msg"] = trans("maintain.matche");
                    $result ["reason"] = "MD5 not matched!";
                    break;

                case Consts::CODE_PKG_ERROR :
                    //$result ["msg"] = Trans::t ( "更新包不完整！" );
                      $result ["msg"] = trans("maintain.integrity");
                    $result ["reason"] = "package not integrated!";
                    break;

                case Consts::CODE_RECOVER_FAILED :
                  //  $result ["msg"] = Trans::t ( "恢复失败！" );
                  $result ["msg"] = trans("maintain.recoverfailed");
                    $result ["reason"] = "recover failed!";
                    break;

                case Consts::CODE_OTHER_ERROR :
                default :
                   // $result ["msg"] = Trans::t ( "未知错误！" );
                $result ["msg"] = trans("maintain.unkonwerror");
                    $result ["reason"] = sprintf ( "unknown error [status:%s]!", $result ["content"] ["status"] );
                    break;
            }
        } else {
            $result ["msg"] = CommandHelper::getErrorMsg ( $result ["code"] );
            SocketLog::log ("Unknown Error From( _parseProgress())". $result ["code"]);
            $result ["reason"] = sprintf ( "unknown error [code:%s]!", $result ["code"] );
        }

        $result ["code"] = ($result ["code"] == Consts::CODE_EXEC_SUCCESS && $result ["content"] ["status"] == Consts::CODE_UPDATE_NORMAL) ? Consts::CODE_SUCCESS : Consts::CODE_FAILURE;
        return $result;
    }

    protected function _logOperation($log_msg) {
        $baseDAO = new BaseDAO ();
        $baseDAO->logOperation ( $log_msg );
    }
}

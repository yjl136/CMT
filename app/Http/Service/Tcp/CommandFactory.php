<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 10:50
 */

namespace App\Http\Service\Tcp;

use App\Http\Service\Consts;
use App\Http\Service\Log\SocketLog;
use App\Http\Service\Log\Log;


class CommandFactory
{
    public static function getCommand($cmd, $target, $params = '', $responsable = true) {
        switch ($cmd) {
            case Consts::CMD_USB_CHECK : // 检测USB
                $command = new Command ( $cmd, $target, true, "ALL" );
                break;
            case Consts::CMD_DEVICE_REBOOT : // 重启设备
                $command = new Command ( $cmd, $target, false, $params );
                break;
            case Consts::CMD_3G_CONTROAL : // 查询或控制3G
                $command = new NetCommand ( $cmd, $target, $responsable, $params );
                break;
            default :
                $command = new Command ( $cmd, $target, $responsable, $params );
                break;
        }
        SocketLog::log ( "****Create command object:" . print_r ( $command, true ), Log::VERBOSE );
        return $command;
    }
}
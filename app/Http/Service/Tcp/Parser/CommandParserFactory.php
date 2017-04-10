<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 14:48
 */

namespace App\Http\Service\Tcp\Parser;
use App\Http\Service\Tcp\Command;

use App\Http\Service\Consts;

class CommandParserFactory
{

    public static function getParser(Command $command) {
        switch ($command->cmd) {

            case Consts::CMD_DEVICE_STATUS : // 上报终端状态，主要用于检测PDL
                $parser = new DeviceStatusCommandParser ( $command );
                break;

            case Consts::CMD_DEVICE_VERSION : // 查询版本信息
                $parser = new DeviceVersionCommandParser ( $command );
                break;

            case Consts::CMD_SET_TEST_MODE : // 设置调试模式
            case Consts::CMD_QUERY_TEST_MODE : // 查询调试模式
                $parser = new WiFiCommandParser ( $command );
                break;

            case Consts::CMD_QUERY_UDPATE_STATUS : // 查询更新状态
                $parser = new UpdateQueryCommandParser ( $command );
                break;

            case Consts::CMD_BITE : // 自检
                $parser = new BiteCommandParser ( $command );
                break;

            default :
                $parser = new CommandParser ( $command );
                break;
        }

        return $parser;
    }
}
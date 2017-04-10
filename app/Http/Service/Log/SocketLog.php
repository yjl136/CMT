<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 10:55
 */

namespace App\Http\Service\Log;


class SocketLog extends Log
{
    public static function log($msg, $level = Log::DEBUG) {
        Log::write ( $msg, $level, Log::FILE, Log::LOG_PATH . "web_socket.log" );
    }
}
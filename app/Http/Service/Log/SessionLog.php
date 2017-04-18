<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/4/17
 * Time: 12:38
 */

namespace App\Http\Service\Log;


class SessionLog extends Log
{
    public static function log($msg, $level = Log::DEBUG) {
        Log::write ( $msg, $level, Log::FILE, Log::LOG_PATH . "web_session.log" );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/20
 * Time: 9:48
 */

namespace App\Http\Service\Log;


class CommandLog extends Log {

    public static function log($msg, $level = Log::DEBUG) {
        Log::write ( $msg, $level, Log::FILE, Log::LOG_PATH . Log::LOG_DEST );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 10:41
 */
namespace App\Http\Service\Tcp;
use App\Http\Service\Consts;
use App\Http\Service\Log\Log;
use App\Http\Service\Log\SocketLog;

class CommandHelper
{

    public static function sendCommand($cmd, $target, $params = '', $responsable = true) {
        try {
            $command = CommandFactory::getCommand ( $cmd, $target, $params, $responsable );
            $excutor = new CommandExecutor ();
            $result = $excutor->execute ( $command );
            if ($result)
                return $result->toArray ();
            else
                return array ();
        } catch ( \Exception $e ) {
            SocketLog::log ( "****Socket error:" . $e->getMessage (), Log::ERROR );
            $result = new CommandResult ( Consts::CODE_SOCKET_ERROR );
            SocketLog::log ( "****command result:" . print_r ( $result, true ) );
            return $result->toArray ();
        }
    }

    public static function getErrorMsg($error_code) {
        switch ($error_code) {
            case Consts::CODE_SOCKET_ERROR :
                $msg = trans("maintain.connectionerror");
                break;
            case Consts::CODE_BAD_FORMAT :
                $msg = trans("maintain.timeout");
                break;
            default :
                $msg =  trans("maintain.unkonwerror") . sprintf ( "CODE[%s]", $error_code );
                break;
        }
        return $msg;
    }
}
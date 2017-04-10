<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 10:56
 */

namespace App\Http\Service\Tcp;

use App\Http\Service\Consts;
use App\Http\Service\Log\SocketLog;
use App\Http\Service\Tcp\Parser\CommandParserFactory;

class CommandExecutor
{
    public $socket;

    public function __construct() {
        $this->socket = @socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
    }

    public function execute(Command $command, $timeout = Consts::DEFAULT_SOCKET_TIMEOUT)  {
        // 设置socket超时间隔
        @socket_set_option ( $this->socket, SOL_SOCKET, SO_RCVTIMEO, array (
            'sec' => $timeout,
            'usec' => 0
        ) );
        if (is_a ( $command, "NetCommand" )) {
            $host = gethostbyname (Consts::CMT_IP );
            $port = Consts::SOCKET_PORT_3G;
        } else {
            $host = gethostbyname ( Consts::SOCKET_IP );
            $port = Consts::SOCKET_PORT;
        }
        if (@socket_connect ( $this->socket, $host, $port )) { // 连接socket服务器
            $cmd = $command->getCommand ();
            if (@socket_write ( $this->socket, $cmd )) { // 发送信令
                SocketLog::log ( ">>>>from cmd:" . $cmd );
                if ($command->responsable) {
                    $response = @socket_read ( $this->socket, 2048000 ); // 读取信令回复
                    SocketLog::log ( "<<<< resp:" . $response );
                    // 解析信令回复
                    $parser = CommandParserFactory::getParser ( $command );
                    $result = $parser->parseResponse ( $response );
                    SocketLog::log ( "****command result:" . print_r ( $result, true ) );
                } else {
                    $result = new CommandResult ( Consts::CODE_EXEC_SUCCESS );
                }
                @socket_close ( $this->socket );
                $this->socket = null;
                return $result;
            } else {
                throw new SocketException ( sprintf ( "Send data failed: %s", $cmd ) );
            }
        } else {
            throw new SocketException ( sprintf ( "Cannot connect to server[%s:%d]", $host, $port ) );
        }
    }

    public function __destruct() {
        if ($this->socket)
            @socket_close ( $this->socket );
    }
}
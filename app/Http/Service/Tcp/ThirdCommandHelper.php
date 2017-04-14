<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/7
 * Time: 8:50
 */

namespace App\Http\Service\Tcp;


use App\Http\Service\Consts;
use App\Http\Service\Log\Log;
use App\Http\Service\Log\SocketLog;

class ThirdCommandHelper
{
/*
    public $socket;

    public function __construct() {
        $this->socket = @socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
    }*/
    /**
     * @param $cmd
     * @param bool $response
     * @param $parameter
     * @return array|CommandResult
     * send socket command
     */
    public function sendSocket($cmd, $response = 1, $type, $parameter)
    {
        try {
            $command = $this->getSocketCmd($cmd, $response, $type, $parameter);      // Build a signaling
            $result = $this->execute($command);                               // Perform signaling
            if ($result)                                                         // Return the json data analytic results
                return $result;
            else
                return array();

        } catch (Exception $e) {
            SocketLog::log("****Socket error:" . $e->getMessage(), Log::ERROR);
            $result = new CommandResult (Consts::CODE_SOCKET_ERROR);
            SocketLog::log("****command result:" . print_r($result, true));
            return $result;
        }
    }

    public function filterResponse($resp){
        $resp = str_replace("\\\"","\"",$resp);
        $resp = str_replace("\"{","{",$resp);
        $resp = str_replace("}\"","}",$resp);
        return $resp;
    }

    /**
     * @param $command
     * @param int $timeout
     * @return array
     * @throws SocketException
     * query socket
     */
    public function execute($command, $timeout = 90)
    {
        $socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);     // Create a client socket connection
        @socket_set_option( $socket, SOL_SOCKET, SO_RCVTIMEO, array(   // Set the socket timeout interval
            'sec' => $timeout,
            'usec' => 0
        ));

        $host = gethostbyname(Consts::SOCKET_IP);
        $port = Consts::THIRD_SOCKET_PORT;
       // $port = Consts::SOCKET_PORT;

        if (@socket_connect($socket, $host, $port)) {                  // A socket connection with the server
            if (@socket_write( $socket, $command)) {                 // Send the socket signaling
                SocketLog::log ( ">>>>from cmd:" . $command );
                $response = @socket_read( $socket, 2048000);        // Read the socket signaling to return the result
                SocketLog::log ( "<<<< resp:" . $response );
                $res = $this->filterResponse($response);
                $res=explode("\n",$res);
                $result = $this->parseResponse($res[0]);         // Parse the returned json data results
                @socket_close($socket);                            // Close the socket connection, release resources
                $socket = null;
                return $result;
            } else {
                throw new SocketException (sprintf("Send data failed: %s", $command));
            }
        } else {
            throw new SocketException (sprintf("Cannot connect to server[%s:%d]", $host, $port));
        }
    }
  /*  public function __destruct() {
        if ($this->socket)
            @socket_close ( $this->socket );
    }*/
    /**
     * @param $cmd
     * @param $response
     * @param $parameter
     * @return string
     * build command
     */
    public function getSocketCmd($cmd, $response, $type, $parameter)
    {
        $command = sprintf('{"cmd": %s,"response": %s,"type": %s,"parameter":"%s"}', $cmd, $response,$type, $parameter);
        return $command;
    }

    /**
     * @param $response
     * @return array
     * parse result
     */
    public function parseResponse($response)
    {
        $obj = json_decode($response);
        $result['cmd'] = $obj->cmd;
        $result['content'] = $obj->content;
        $result['progress'] = $obj->progress;
        $result['result'] = $obj->result;
        return $result;
    }
}
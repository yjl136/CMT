<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 14:49
 */

namespace App\Http\Service\Tcp\Parser;
use App\Http\Service\Consts;
use App\Http\Service\Log\CommandLog;
use App\Http\Service\Log\Log;
use App\Http\Service\Tcp\Command;
use App\Http\Service\Tcp\CommandResult;


class CommandParser
{
    public $command;

    public function __construct(Command $command) {
        $this->command = $command;
    }

    public function parseResponse($response) {

        if (empty ( $response )) { // 信令回复为空
            $cmdResult = new CommandResult ( Consts::CODE_BAD_FORMAT );

            CommandLog::log ( sprintf ( "Response is empty" ), Log::ERROR );
        } else {
            $cmd = $this->getItemValue ( $response, "cmd" );
            CommandLog::log ( sprintf ( "Response command is %s", $cmd ) );

            if (intval ( $cmd ) != $this->command->cmd) { // 信令回复与信令请求不匹配
                $cmdResult = new CommandResult ( Consts::CODE_WRONG_CMD );
                CommandLog::log ( sprintf ( "Response command [%s] is not matched [%s]", $cmd, $this->command->cmd ), Log::ERROR );
            } else {
                // 获取结果状态码
                $result_code = $this->getItemValue ( $response, "result" );
                if ($result_code != "") {
                    $result_code = intval ( $result_code );
                    $cmdResult = new CommandResult ( $result_code );
                    CommandLog::log ( sprintf ( "Response result code is %s", $result_code ) );

                    // 获取结果详细信息
                    $content = $this->parseContent ( $response );
                    $cmdResult->content = $content;
                    CommandLog::log ( sprintf ( "Response result info is %s", print_r ( $content, true ) ) );
                } else {
                    $cmdResult = new CommandResult ( Consts::CODE_EXEC_FAILURE );
                    CommandLog::log ( sprintf ( "Response command is failed" ), Log::ERROR );
                }
            }
        }
        return $cmdResult;
    }

    public function parseContent($response) {
        $content = $this->getItemValue ( $response, "content" );
        $info = $this->getItemValue ( $content, "str" );
        return $info;
    }

    public function getItemValue($content, $key) {
        if (preg_match ( "/\<$key\>(.*?)\<\/$key\>/s", $content, $matches )) {
            $value = $matches [1];
        } else {
            $value=sprintf ( "Item [%s] is not found in content: ", $key, $content );
            CommandLog::log ( sprintf ( "Item [%s] is not found in content: ", $key, $content ), Log::WARNING );
        }
        return $value;
    }
}
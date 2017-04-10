<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/13
 * Time: 17:21
 */

namespace App\Http\Service\Tcp;


class NetCommand extends Command
{
    protected function buildCommand() {
        $this->sendTime = time ();
        $config = array (
            "cmdType" => 0,
            "cmd" => $this->cmd,
            "cmdTarget" => $this->target,
            "timestamp" => $this->sendTime,
            "response" => $this->responsable
        );
        $cmd = sprintf ( "<net>%s<parameter>%s</parameter></net>", $this->buildItems ( $config ), $this->buildItems ( $this->params ) );
        return $cmd;
    }
}
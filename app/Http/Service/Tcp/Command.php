<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 10:51
 */

namespace App\Http\Service\Tcp;

class Command {
    public $cmd; // 信令命令码
    public $target; // 目标设备
    public $responsable; // 是否需要回复
    public $params; // 信令参数
    public $sendTime; // 发送时间
    public function __construct($cmd, $target, $responsable = true, $params = '') {
        $this->cmd = $cmd;
        $this->target = $target;
        $this->responsable = $responsable ? 1 : 0;
        $this->params = $params;
    }

    protected function buildCommand() {
        $this->sendTime = time ();

        $config = array (
            "cmdType" => 0,
            "cmd" => $this->cmd,
            "cmdTarget" => $this->target,
            "timestamp" => $this->sendTime,
            "response" => $this->responsable
        );
        $cmd = sprintf ( "<cmt>%s<parameter>%s</parameter></cmt>", $this->buildItems ( $config ), $this->buildItems ( $this->params ) );
        return $cmd;
    }

    protected function buildItems($items) {
        if (is_array ( $items )) {
            $item_str = "";
            foreach ( $items as $key => $value ) {
                $item_str .= "<$key>$value</$key>";
            }
        } else if (is_string ( $items )) {
            $item_str = $items;
        }
        return $item_str;
    }

    public function getCommand() {
        return $this->buildCommand ();
    }

    public function getSendTime() {
        return date ( "Y-m-d H:i:s", $this->sendTime );
    }
}
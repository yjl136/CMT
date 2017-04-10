<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/20
 * Time: 9:49
 */

namespace App\Http\Service\Tcp;

use App\Http\Service\Consts;

class CommandResult {
    public $resultCode;
    public $content;

    public function __construct($result_code = Consts::CODE_EXEC_SUCCESS) {
        $this->resultCode = $result_code;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function toArray() {
        $result = array ();
        $result ["code"] = $this->resultCode;
        $result ["content"] = $this->content;
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/1/19
 * Time: 11:02
 */

namespace App\Http\Service\Tcp;

use App\Http\Service\Consts;

class SocketException extends \ErrorException {

    public function __construct($message, $code = Consts::CODE_SOCKET_ERROR) {
        parent::__construct ( $message, $code, Consts::EXCEPTION_LEVEL_ERROR, __FILE__, __LINE__ );
    }
}
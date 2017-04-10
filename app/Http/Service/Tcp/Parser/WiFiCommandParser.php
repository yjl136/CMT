<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 9:33
 */

namespace App\Http\Service\Tcp\Parser;


class WiFiCommandParser extends CommandParser
{
    public function parseContent($response) {
        $mode = $this->getItemValue ( $response, "str" );
        $remainSeconds = $this->getItemValue ( $response, "remainSeconds" );
        $content = array (
            "mode" => $mode,
            "remainSeconds" => $remainSeconds
        );
        return $content;
    }
}
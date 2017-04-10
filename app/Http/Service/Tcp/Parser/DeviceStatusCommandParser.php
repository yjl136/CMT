<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 9:39
 */

namespace App\Http\Service\Tcp\Parser;


class DeviceStatusCommandParser extends CommandParser
{
    public function parseContent($response) {
        $target = $this->getItemValue ( $response, "targetType" );
        $status = $this->getItemValue ( $response, "status" );
        $site = $this->getItemValue ( $response, "site" );
        $ip = $this->getItemValue ( $response, "ip" );
        $content = array (
            "target" => $target,
            "status" => $status,
            "site" => $site,
            "ip" => $ip
        );
        return $content;
    }
}
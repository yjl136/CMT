<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 9:36
 */

namespace App\Http\Service\Tcp\Parser;


class DeviceVersionCommandParser extends CommandParser
{
    public function parseContent($response) {
        $id = $this->getItemValue ( $response, "id" );
        $version = $this->getItemValue ( $response, "version" );
        $sys_version = $this->getItemValue ( $response, "systemversion" );
        $app_version = $this->getItemValue ( $response, "appversion" );
        $content = array (
            "id" => $id,
            "version" => $version,
            "sys_version" => $sys_version,
            "app_version" => $app_version
        );
        return $content;
    }
}
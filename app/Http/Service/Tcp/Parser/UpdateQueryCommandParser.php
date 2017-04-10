<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 9:32
 */

namespace App\Http\Service\Tcp\Parser;


class UpdateQueryCommandParser extends CommandParser
{
    public function parseContent($response) {
        $status = $this->getItemValue ( $response, "status" );
        $type = $this->getItemValue ( $response, "type" );
        $progress = $this->getItemValue ( $response, "progress" );
        $info = $this->getItemValue ( $response, "str" );

        $succ_count = array ();
        $succ_content = $this->getItemValue ( $response, "success" );
        $succ_count ["server"] = $this->getItemValue ( $succ_content, "server" );
        $succ_count ["cmt"] = $this->getItemValue ( $succ_content, "cmt" );
        $succ_count ["adb"] = $this->getItemValue ( $succ_content, "adb" );
        $succ_count ["seb"] = $this->getItemValue ( $succ_content, "seb" );
        $succ_count ["smartlcd"] = $this->getItemValue ( $succ_content, "smartlcd" );

        $fail_count = array ();
        $fail_content = $this->getItemValue ( $response, "fail" );
        $fail_count ["server"] = $this->getItemValue ( $fail_content, "server" );
        $fail_count ["cmt"] = $this->getItemValue ( $fail_content, "cmt" );
        $fail_count ["adb"] = $this->getItemValue ( $fail_content, "adb" );
        $fail_count ["seb"] = $this->getItemValue ( $fail_content, "seb" );
        $fail_count ["smartlcd"] = $this->getItemValue ( $fail_content, "smartlcd" );

        $content = array (
            "status" => $status,
            "type" => $type,
            "progress" => $progress,
            "info" => $info,
            "succ_count" => $succ_count,
            "fail_count" => $fail_count
        );
        return $content;
    }
}
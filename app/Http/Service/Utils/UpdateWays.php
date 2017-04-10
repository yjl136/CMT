<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/13
 * Time: 15:40
 */

namespace App\Http\Service\Utils;


use App\Http\Service\Consts;

class UpdateWays
{
    public static function getSysUpdateWays() {
        $update_ways = array ();

        if (getFilterGroup () != "wifi_dhj") {
            array_push ( $update_ways, array (
                "way" => Consts::TRANS_WAY_USB,
                "name" => "USB"
            ) );

            array_push ( $update_ways, array (
                "way" => Consts::TRANS_WAY_FTP,
                "name" => "FTP"
            ) );
        }

        return $update_ways;
    }

    private static function _getTransWayText($way) {
        switch ($way) {
            case Consts::TRANS_WAY_USB :
                $text = "USB";
                break;

            case Consts::TRANS_WAY_3G :
               // $text = Trans::t ( "E-mail" );
                $text =  "E-mail" ;
                break;

            case Consts::TRANS_WAY_PDL :
                $text = "PDL";
                break;

            case Consts::TRANS_WAY_COMSERVER :
                //$text = Trans::t ( "FTP-Server" );
                $text = "FTP-Server";
                break;

            default :
                $text = "";
                break;
        }
        return $text;
    }
    public static function getTransWays() {
        // 默认选中的传输方式
        $transWays = array (
            Consts::TRANS_WAY_USB => 1,
           Consts:: TRANS_WAY_3G => 0,
            Consts::TRANS_WAY_COMSERVER => 0
        );

        $result = array ();
        foreach ( $transWays as $key => $value ) {
            $result [$key] ["text"] = self::_getTransWayText ( $key );
            $result [$key] ["checked"] = $value;
        }
        return $result;
    }

    public static function getFormatTypes() {
        // 默认选中的格式类型
        $formatTypes = array (
            Consts::FT_EXCEL => 1
           // Consts::FT_CSV => 0 ,
        );
        $result = array ();
        foreach ( $formatTypes as $key => $value ) {
            $result [$key] ["text"] = self::_getFormatTypeText ( $key );
            $result [$key] ["checked"] = $value;
        }
        return $result;
    }


    private static function _getFormatTypeText($type) {
        switch ($type) {
            case Consts::FT_EXCEL :
                $text = "Excel";
                break;

            case Consts::FT_XML :
                $text = "XML";
                break;
            case Consts::FT_CSV :
                $text = "CSV";
                break;

            default :
                $text = "";
                break;
        }
        return $text;
    }
}
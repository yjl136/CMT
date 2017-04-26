<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/7
 * Time: 14:43
 */

namespace App\Http\Service\Utils;


use App\Http\Service\Consts;

class Formatter
{

    public static function formatDeviceValue($type, $value) {
        $result = $value;
        switch ($type) {
            case Consts:: PT_RUNNING_STATE : // 应用运行状态
                $result = Formatter::formatState ( $value );
                break;

            case Consts::PT_RUNNING_TIME :
            case Consts::PT_CPE_UPTIME :
                $result = Formatter::formatTime ( $value );
                break;

            case Consts::PT_CPU_IDLE :
                $result = Formatter::formatPercentage ( $value );
                break;

            case Consts::PT_MEM_TOTAL :
            case Consts::PT_MEM_FREE :
                $result = Formatter::formatDiskText ( $value );
                break;

            case Consts::PT_CPU_TEMP :
            case Consts::PT_SYS_TEMP :
                $result = Formatter::formatTemperature ( $value );
                break;

            case Consts::PT_UP_TIME :
                $result = Formatter::formatTime ( $value / 100 );
                break;

            case Consts::PT_3G_STATUS :
            case Consts::PT_CABIN_DOOR_STATUS :
            case Consts::PT_PA_STATUS :
            case Consts::PT_CPE_STATUS :
                $result = Formatter::formatStatus ( $value );
                break;

            case Consts::PT_WLAN_RECV :
            case Consts::PT_WLAN_SEND :
                $result = Formatter::formatBits ( $value );
                break;

            case Consts::PT_MEM_SWAP_ALARM : // 交换内存告警
                $result = Formatter::formatAlarmFlag ( $value );
                break;

            case Consts::PT_RECV_BYTES :
            case Consts::PT_SEND_BYTES :
                $result = Formatter::formatBytes ( $value );
                break;

            default :
                break;
        }
        return $result;
    }

    public static function formatDiskText($value) {
        $result = "";
        $size = intval ( $value );
        if ($size >= 1048576) { // 1024*1024
            $result = sprintf ( "%0.2f GB", $size / (1048576.00) );
        } elseif ($size >= 1024) {
            $result = sprintf ( "%0.2f MB", $size / 1024.00 );
        } else {
            $result = sprintf ( "%d KB", $size );
        }
        return $result;
    }

    public static function formatPercentage($value) {
        if (empty ( $value )) {
            $value = "1%";
        } else if (intval ( $value ) <= 100) {
            $value = $value . "%";
        } else { // 当snmp进程被杀死后，数据可能溢出
            $value = "N/A";
        }
        return $value;
    }

    public static function formatTemperature($value) {
        $value = intval ( $value ) . " ℃";
        return $value;
    }

    public static function formatTime($value) {
        $result = "";
        $seconds = intval ( $value );
        if ($seconds > 0) {
            $day = floor ( $seconds / 86400 ); // 1day
            $seconds %= 86400;
            $hour = floor ( $seconds / 3600 ); // 1hour
            $seconds %= 3600;
            $minute = floor ( $seconds / 60 ); // 1min
            $seconds %= 60;
            $second = $seconds; // 1s

            if ($day > 0) {
                $result .= $day . "d ";
            }
            if ($hour > 0) {
                $result .= $hour . "h ";
            }
            if ($minute > 0) {
                $result .= $minute . "m ";
            }
            if ($second > 0) {
                $result .= $second . "s ";
            }
        } else {
            $result = "N/A";
        }
        return $result;
    }

    public static function formatState($value) {
        $state = "N/A";
        if (trim ( $value ) == '0') {
           // $state = Trans::t ( "已停止" );
            $state =  "已停止" ;
        } elseif (trim ( $value ) == '1') {
           // $state = Trans::t ( "运行中" );
            $state = "运行中" ;
        }
        return $state;
    }

    public static function formatStatus($value) {
        if (trim ( $value ) == '1') {
           // $state = Trans::t ( "开启" );
            $state =  "开启" ;
        } elseif (trim ( $value ) == '0') {
           // $state = Trans::t ( "关闭" );
            $state =  "关闭" ;
        } elseif (empty ( $state )) {
            $state = "N/A";
        } else {
            //$state = Trans::t ( "超时" );
            $state = "超时" ;
        }
        return $state;
    }

    public static function formatBytes($value) {
        $text = "0 B";
        $value = doubleval ( $value );
        if (! empty ( $value )) {
            if ($value >= 1073741824) { // 1024*1024*1024
                $text = sprintf ( "%.2f GB", $value / 1073741824 );
            } else if ($value >= 1048576) { // 1024*1024
                $text = sprintf ( "%.2f MB", $value / 1048576 );
            } else if ($value >= 1024) {
                $text = sprintf ( "%.2f KB", $value / 1024 );
            } else if ($value >= 0) {
                $text = sprintf ( "%.2f B", $value );
            }
        }
        return $text;
    }

    public static function formatBits($value) {
        $text = "0 b";
        $value = doubleval ( $value );
        if (! empty ( $value )) {
            if ($value >= 1073741824) { // 1024*1024*1024
                $text = sprintf ( "%.2f Gb", $value / 1073741824 );
            } else if ($value >= 1048576) {
                $text = sprintf ( "%.2f Mb", $value / 1048576 );
            } else if ($value >= 1024) { // 1024*1024
                $text = sprintf ( "%.2f Kb", $value / 1024 );
            } else if ($value >= 0) {
                $text = sprintf ( "%.2f b", $value );
            }
        }
        return $text;
    }

    public static function formatAlarmFlag($value) {
        if (empty ( $value )) {
           // $text = Trans::t ( "有" );
            $text = "有";
        } else {
            //$text = Trans::t ( "无" );
            $text = "无";
        }
        return $text;
    }

    public static function formatAlarmCategory($alarm_category) {
        switch ($alarm_category) {
            case 1 :
               // $alarm_category = Trans::t ( '系统告警' );
                $alarm_category = '系统告警' ;
                break;

            case 2 :
                //$alarm_category = Trans::t ( '数据库告警' );
                $alarm_category =  '数据库告警' ;
                break;

            case 3 :
                //$alarm_category = Trans::t ( '网络告警' );
                $alarm_category = '网络告警' ;
                break;

            case 4 :
               // $alarm_category = Trans::t ( '处理错误告警' );
                $alarm_category = '处理错误告警' ;
                break;

            case 5 :
                //$alarm_category = Trans::t ( '服务质量告警' );
                $alarm_category =  '服务质量告警' ;
                break;

            case 6 :
                //$alarm_category = Trans::t ( '环境告警' );
                $alarm_category = '环境告警' ;
                break;

            default :
                $alarm_category =  '无效分类' ;
                break;
        }
        return $alarm_category;
    }

    public static function formatAlarmLevel($alarm_level) {
        switch ($alarm_level) {
            case 0 :
              //  $alarm_level = Trans::t ( '全部' );
                $alarm_level =  '全部' ;
                break;
            case 1 :
                //$alarm_level = Trans::t ( '信息' );
                $alarm_level =  '信息' ;
                break;
            case 2 :
               // $alarm_level = Trans::t ( '警告' );
               // $alarm_level = '警告' ;
                break;
            case 3 :
                //$alarm_level = Trans::t ( '错误' );
                $alarm_level = '错误' ;
                break;
            default :
               // $alarm_level = Trans::t ( '无效' );
                $alarm_level =  '无效' ;
                break;
        }
        return $alarm_level;
    }

    public static function formatAlarmLevelCss($alarm_level) {
        switch ($alarm_level) {
            case 1 :
                $alarm_level = "label-info";
                break;
            case 2 :
                $alarm_level = "label-alert";
                break;
            case 3 :
                $alarm_level = "label-danger";
                break;
            default :
                $alarm_level = "label-inverse";
                break;
        }
        return $alarm_level;
    }

    public static function formatAlarmStatus($clear_status) {
        switch ($clear_status) {
            case ALARM_FILTER_ALL :
               // $text = Trans::t ( "全部" );
                $text =  "全部";
                break;

            case ALARM_FILTER_CURRENT :
                //$text = Trans::t ( "当前告警" );
                $text = "当前告警" ;
                break;

            case ALARM_FILTER_HISTORY :
                //$text = Trans::t ( "历史告警" );
                $text = "历史告警" ;
                break;
        }
        return $text;
    }

    public static function formatSecureMode($mode) {
        switch ($mode) {
            case SECURE_MODE_WAP_PSK :
                $mode_text = Trans::t ( "WAP_PSK" );
                ;
                break;

            case SECURE_MODE_WAP2_PSK :
                $mode_text = Trans::t ( "WAP2_PSK" );
                ;
                break;

            default :
                $mode_text = Trans::t ( "开放" );
                break;
        }
        return $mode_text;
    }

    public static function formatUserType($type) {
        $type_text = "";
        switch ($type) {
            case "operate" :
                $type_text = Trans::t ( "运营管理" );
                break;

            case "config" :
                $type_text = Trans::t ( "系统维护" );
                break;

            case "super" :
                $type_text = Trans::t ( "超级管理" );
                break;

            case "debug" :
                $type_text = Trans::t ( "出厂调试" );
                break;

            case md5 ( "operate" ) :
                $type_text = "Crew";
                break;

            case md5 ( "config" ) :
                $type_text = "Maintenance";
                break;

            case md5 ( "super" ) :
                $type_text = "Super Admin";
                break;

            case md5 ( "debug" ) :
                $type_text = "Factory";
                break;

            default :
                break;
        }
        return $type_text;
    }

    public static function formatCabinClass($cabin_class) {
        switch ($cabin_class) {
            case 0 :
                $text = Trans::t ( "头等舱" );
                break;

            case 1 :
                $text = Trans::t ( "商务舱" );
                break;

            default :
                $text = Trans::t ( "经济舱" );
                break;
        }
        return $text;
    }

    public static function formatIDType($ID_type) {
        switch ($ID_type) {
            case 1 :
                $text = Trans::t ( "身份证" );
                break;

            case 2 :
                $text = Trans::t ( "军官证" );
                break;

            case 3 :
                $text = Trans::t ( "护照" );
                break;

            default :
                $text = Trans::t ( "其他" );
                break;
        }
        return $text;
    }

    public static function formatIP($ip) {
        if ($_SESSION ["cmt_user_type"] != "super") {
            $count = 4;
            $pieces = explode ( '.', $ip, $count );
            if (count ( $pieces ) == $count) {
                $ip = sprintf ( "%s.%s.*.*", $pieces [0], $pieces [1] );
            }
        }
        return $ip;
    }

    public static function formatMac($mac) {
        if ($_SESSION ["cmt_user_type"] != "super") {
            $count = 6;
            $pieces = explode ( ':', $mac, $count );
            if (count ( $pieces ) == $count) {
                $mac = sprintf ( "%s:%s:%s:*:*:*", $pieces [0], $pieces [1], $pieces [2] );
            }
        }
        return $mac;
    }

    public static function formatLatitude($latitude) {
        $latitude = trim ( $latitude );
        if (substr ( $latitude, 0, 1 ) == "-") { // South
            $latitude = substr_replace ( $latitude, "", 0, 1 ) . "°S";
        } else { // North
            $latitude = $latitude . "°N";
        }
        return $latitude;
    }

    public static function formatLongitude($longitude) {
        $longitude = trim ( $longitude );
        if (substr ( $longitude, 0, 1 ) == "-") { // West
            $longitude = substr_replace ( $longitude, "", 0, 1 ) . "°W";
        } else { // East
            $longitude = $longitude . "°E";
        }
        return $longitude;
    }

    public static function formatCPEBiteResult($value) {
        switch ($value) {
            case CPE_BITE_NOT_YET :
                $text = Trans::t ( "尚未自检" );
                break;

            case CPE_BITE_IN_PROC :
                $text = Trans::t ( "正在自检" );
                break;

            case CPE_BITE_FAILED :
                $text = Trans::t ( "自检失败" );
                break;

            case CPE_BITE_SUCCESS :
                $text = Trans::t ( "自检成功" );
                break;

            default :
                break;
        }
        return $text;
    }

    public static function formatBandWidth($value) {
        if (! empty ( $value )) {
            $value = $value . " MHz";
        }
        return $value;
    }

    public static function formatDeviceName($dev_type, $dev_name, $dev_position) {
        switch ($dev_type) {
            case Consts::DEV_TYPE_CAP :
                $name = sprintf ( "%s-%s", $dev_name, str_replace ( "0-ap-", "", $dev_position ) );
                break;

            default :
                $name = $dev_name; // sprintf("%s (%s)",$device["Name"], $device["DevPosition"]);
                break;
        }
        return $name;
    }

    public static function formatDeviceStatus($status) {
        switch ($status) {
            case 2 :
               // $text = Trans::t ( "在线" );
                $text = "在线" ;
                break;

            default :
                //$text = Trans::t ( "离线" );
                $text =  "离线";
                break;
        }
        return $text;
    }

    public static function formatCAPStatus($status) {
        switch ($status) {
            case 1 :
                $text = Trans::t ( "在线" );
                break;

            default :
                $text = Trans::t ( "离线" );
                break;
        }
        return $text;
    }


}
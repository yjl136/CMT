<?php

namespace App\Support\Helpers;




// 设备分类
define ( "DEV_TYPE_ALL", 0 ); // ALL
define ( "DEV_TYPE_CMT", 3 ); // CMT
define ( "DEV_TYPE_SERVER", 4 ); // Server
define ( "DEV_TYPE_ADB", 5 ); // ADB
define ( "DEV_TYPE_APS", 13 ); // AC
define ( "DEV_TYPE_CPE", 14 ); // CPE
define ( "DEV_TYPE_CAP", 15 ); // CAP-2000
define ( "DEV_TYPE_KU", 16 ); // Ku
define ( "DEV_TYPE_TWLU", 17 ); // TWLU
define ( "DEV_TYPE_CAP_KONTRON", 18 ); // Kontron CAP

// 自检参数
define ( "PT_RUNNING_STATE", 1 ); // 运行状态
define ( "PT_RUNNING_TIME", 2 ); // 运行时间
define ( "PT_CPU_IDLE", 3 ); // 空闲CPU
define ( "PT_MEM_TOTAL", 4 ); // 总内存
define ( "PT_MEM_FREE", 5 ); // 空闲内存
define ( "PT_CPU_TEMP", 6 ); // CPU温度
define ( "PT_SYS_TEMP", 7 ); // 系统温度
define ( "PT_AC_NAME", 8 ); // AC名称
define ( "PT_AC_MODEL", 9 ); // AC型号
define ( "PT_AC_VERSION", 10 ); // AC版本
define ( "PT_UP_TIME", 11 ); // AC上线时间(单位：10ms)
define ( "PT_MAX_AP_LIMIT", 12 ); // 最大AP数量限制
define ( "PT_MAX_CLIENT_LIMIT", 13 ); // 最大客户数限制
define ( "PT_INSTALLED_LICENSES", 14 ); // AP已安装许可
define ( "PT_IN_USE_LICENSES", 15 ); // AP使用许可
define ( "PT_AP_ONLINE", 16 ); // 在线AP
define ( "PT_AP_OFFLINE", 17 ); // 离线AP
define ( "PT_USER_WLAN", 18 ); // 无线用户数
define ( "PT_USER_WLAN_2DOT4G", 19 ); // 2.4G用户数
define ( "PT_USER_WLAN_5G", 20 ); // 5G用户数
define ( "PT_USER_LAN", 21 ); // 有线用户数
define ( "PT_ALARM_TOTAL", 22 ); // 告警总数
define ( "PT_ALARM_CRIT", 23 ); // 关键告警数量
define ( "PT_ALARM_MAJOR", 24 ); // 重要告警数量
define ( "PT_ALARM_MINOR", 25 ); // 次要告警数量
define ( "PT_ROGUE_APS", 26 ); // 非法AP数量
define ( "PT_ROGUE_STATIONS", 27 ); // 非法用户数
define ( "PT_ROGUE_UNKNOWN_DEV", 28 ); // 非法未知设备数
define ( "PT_CLEAR_ESS_PROFILE", 29 ); // 明文ESS模板数量
define ( "PT_SECURE_ESS_PROFILE", 30 ); // 加密ESS模板数量
define ( "PT_CAPTIVE_PORTAL_ESS_PROFILE", 31 ); // 网页认证ESS模板数量
define ( "PT_3G_STATUS", 32 ); // 3G状态
define ( "PT_CABIN_DOOR_STATUS", 33 ); // 舱门状态
define ( "PT_WOW_STATUS", 33 ); // WoW(Weight on Wheel) 起落架状态
define ( "PT_PA_STATUS", 34 ); // PA状态
define ( "PT_WLAN_RECV", 35 ); // WiFi总接收流(单位：bit)
define ( "PT_WLAN_SEND", 36 ); // WiFi总发送流(单位：bit)
define ( "PT_MEM_SWAP_ALARM", 37 ); // 交换内存告警
define ( "PT_3G_IP", 38 ); // 3G的IP地址
define ( "PT_AUB_LOAD_VER", 39 ); // AUB版本加载自检结果
define ( "PT_RFU_LOAD_VER", 40 ); // RFU版本加载自检结果
define ( "PT_RFU_RF_CALIB", 41 ); // RFU射频定标自检结果
define ( "PT_CPE_UPTIME", 42 ); // CPE上线时间
define ( "PT_CPE_STATUS", 43 ); // 空地状态
define ( "PT_CPE_PUBLIC_IP", 44 ); // 公网IP地址
define ( "PT_RECV_BYTES", 45 ); // CPE总接收字节数
define ( "PT_SEND_BYTES", 46 ); // CPE总发送字节数
define ( "PT_CPE_IP", 56 ); // CPE IP
define ( "PT_CPE_MAC", 57 ); // CPE MAC
define ( "PT_CONN_STATUS", 67 ); // CAP网络连接状态之前为67

// 加密方式
define ( "SECURE_MODE_OPEN", 0 ); // 开放
define ( "SECURE_MODE_WAP_PSK", 1 ); // WAP_PSK
define ( "SECURE_MODE_WAP2_PSK", 2 ); // WAP2_PSK

// CPE自检结果
define ( "CPE_BITE_NOT_YET", 0 ); // 尚未自检
define ( "CPE_BITE_IN_PROC", 1 ); // 正在
define ( "CPE_BITE_FAILED", 2 ); // 自检失败
define ( "CPE_BITE_SUCCESS", 3 ); // 自检成功
class Formatter {

    public static function formatDeviceValue($type, $value) {
        $result = $value;
        switch ($type) {
            case PT_RUNNING_STATE : // 应用运行状态
                $result = Formatter::formatState ( $value );
                break;

            case PT_RUNNING_TIME :
            case PT_CPE_UPTIME :
                $result = Formatter::formatTime ( $value );
                break;

            case PT_CPU_IDLE :
                $result = Formatter::formatPercentage ( $value );
                break;

            case PT_MEM_TOTAL :
            case PT_MEM_FREE :
                $result = Formatter::formatDiskText ( $value );
                break;

            case PT_CPU_TEMP :
            case PT_SYS_TEMP :
                $result = Formatter::formatTemperature ( $value );
                break;

            case PT_UP_TIME :
                $result = Formatter::formatTime ( $value / 100 );
                break;

            case PT_3G_STATUS :
            case PT_CABIN_DOOR_STATUS :
            case PT_PA_STATUS :
            case PT_CPE_STATUS :
                $result = Formatter::formatStatus ( $value );
                break;

            case PT_WLAN_RECV :
            case PT_WLAN_SEND :
                $result = Formatter::formatBits ( $value );
                break;

            case PT_MEM_SWAP_ALARM : // 交换内存告警
                $result = Formatter::formatAlarmFlag ( $value );
                break;

            case PT_RECV_BYTES :
            case PT_SEND_BYTES :
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

    public static function formatAltitude($value) {
        $value = intval ( $value ) . " Feet";
        return $value;
    }

    public static function formatSpeed($value) {
        $value = intval ( $value ) . " Knots";
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
            $state = trans ( "已停止" );
        } elseif (trim ( $value ) == '1') {
            $state = trans ( "button.Running" );
        }
        return $state;
    }

    public static function formatAppStatus($value){
        $status = "N/A";
        if (trim ( $value ) == '0') {
            $status = 'label-danger';
        } elseif (trim ( $value ) == '1') {
            $status = 'label-success';
        }
        return $status;
    }

    public static function formatStatus($value) {
        if (trim ( $value ) == '1') {
            $state = trans ( "开启" );
        } elseif (trim ( $value ) == '0') {
            $state = trans ( "关闭" );
        } elseif (empty ( $state )) {
            $state = "N/A";
        } else {
            $state = trans ( "超时" );
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
            $text = trans ( "有" );
        } else {
            $text = trans ( "无" );
        }
        return $text;
    }

    public static function formatAlarmCategory($alarm_category) {
        switch ($alarm_category) {
            case 1 :
                $alarm_category = trans ( '系统告警' );
                break;

            case 2 :
                $alarm_category = trans ( '数据库告警' );
                break;

            case 3 :
                $alarm_category = trans ( '网络告警' );
                break;

            case 4 :
                $alarm_category = trans ( '处理错误告警' );
                break;

            case 5 :
                $alarm_category = trans ( '服务质量告警' );
                break;

            case 6 :
                $alarm_category = trans ( '环境告警' );
                break;

            default :
                $alarm_category = trans ( '无效分类' );
                break;
        }
        return $alarm_category;
    }

    public static function formatAlarmLevel($alarm_level) {
        switch ($alarm_level) {
            case 0 :
                $alarm_level = trans ( '全部' );
                break;
            case 1 :
                $alarm_level = trans ( '信息' );
                break;
            case 2 :
                $alarm_level = trans ( '警告' );
                break;
            case 3 :
                $alarm_level = trans ( '错误' );
                break;
            default :
                $alarm_level = trans ( '无效' );
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
                $text = trans ( "全部" );
                break;

            case ALARM_FILTER_CURRENT :
                $text = trans ( "当前告警" );
                break;

            case ALARM_FILTER_HISTORY :
                $text = trans ( "历史告警" );
                break;
        }
        return $text;
    }

    public static function formatSecureMode($mode) {
        switch ($mode) {
            case SECURE_MODE_WAP_PSK :
                $mode_text = trans ( "WAP_PSK" );
                ;
                break;

            case SECURE_MODE_WAP2_PSK :
                $mode_text = trans ( "WAP2_PSK" );
                ;
                break;

            default :
                $mode_text = trans ( "开放" );
                break;
        }
        return $mode_text;
    }

    public static function formatUserType($type) {
        $type_text = "";
        switch ($type) {
            case "operate" :
                $type_text = trans ( "运营管理" );
                break;

            case "config" :
                $type_text = trans ( "系统维护" );
                break;

            case "super" :
                $type_text = trans ( "超级管理" );
                break;

            case "debug" :
                $type_text = trans ( "出厂调试" );
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
                $text = trans ( "头等舱" );
                break;

            case 1 :
                $text = trans ( "商务舱" );
                break;

            default :
                $text = trans ( "经济舱" );
                break;
        }
        return $text;
    }

    public static function formatIDType($ID_type) {
        switch ($ID_type) {
            case 1 :
                $text = trans ( "身份证" );
                break;

            case 2 :
                $text = trans ( "军官证" );
                break;

            case 3 :
                $text = trans ( "护照" );
                break;

            default :
                $text = trans ( "其他" );
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
                $text = trans ( "尚未自检" );
                break;

            case CPE_BITE_IN_PROC :
                $text = trans ( "正在自检" );
                break;

            case CPE_BITE_FAILED :
                $text = trans ( "自检失败" );
                break;

            case CPE_BITE_SUCCESS :
                $text = trans ( "自检成功" );
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
            case DEV_TYPE_CAP :
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
                $text = trans ( "在线" );
                break;

            default :
                $text = trans ( "离线" );
                break;
        }
        return $text;
    }

    public static function formatCAPStatus($status) {
        switch ($status) {
            case 1 :
                $text = trans ( "在线" );
                break;

            default :
                $text = trans ( "离线" );
                break;
        }
        return $text;
    }
}
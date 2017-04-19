<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/4
 * Time: 11:29
 */

namespace App\Http\Service;


class Consts
{

    const DIRECTORY_SEPARATOR = "/";
    /*****************************************更新方式常量*************************************************/
    const TRANS_WAY_USB = 1;
    const TRANS_WAY_3G = 2;
    const TRANS_WAY_SMTP = 3;
    const TRANS_WAY_FTP = 4;
    const TRANS_WAY_ATG = 5;
    const TRANS_WAY_KU = 8;
    const TRANS_WAY_PDL = 11;
    const TRANS_WAY_TWLU = 16;
    const TRANS_WAY_HTTP = 19;
    const TRANS_WAY_SFTP = 20;
    const TRANS_WAY_COMSERVER = 21;

    /******************************************返回结果码常量********************************************/
   const CODE_BAD_FORMAT = -3;
   const CODE_WRONG_CMD = -2;
   const CODE_SOCKET_ERROR = -1;
  const EXCEPTION_LEVEL_ERROR = 1;// 错误级别，对应E_ERROR
   const CODE_EXEC_SUCCESS = 0;
   const CODE_EXEC_FAILURE = 1;
   const CODE_3G_CLOSE = 0;// 3G关闭
   const CODE_3G_OPEN = 1;// 3G打开
   const CODE_NEW_PACKAGE = 0;// 新更新包
   const CODE_NO_PACKAGE = 1;// 没有更新包
   const CODE_NO_PKG_INFO = 2;// 获取更新包信息失败
   const CODE_SAME_VERSION = 3;// 相同更新包
   const CODE_OLD_VERSION = 4;// 旧更新包
   const CODE_CONFIG_ERROR = 5;// 配置文件错误
   const CODE_UNKNOW_ERROR = 6;// 其他错误
   const CODE_PKG_TOO_BIG = 7;// 更新包过大
   const CODE_NO_PLUGIN_DISK = 8;// 没有外挂硬盘
   const CODE_SAME_PKG_UNCOMPLETED = 9;//  相同更新包，上次媒体更新失败
   const CODE_UPDATE_NORMAL = 0;//  更新正常
   const CODE_UPDATE_ERROR = 1;//   更新失败
   const CODE_NETWORK_ERROR = 2;//   网络错误
   const CODE_GET_FILE_FAIL = 3;//   获取文件失败
   const CODE_FILE_NOT_FOUND = 4;//   文件不存在
   const CODE_DB_BACKUP_ERROR = 5;//   数据库备份失败
   const CODE_DB_UPDATE_ERROR = 6;//   数据库更新失败
   const CODE_VIDEO_TABLE_ERROR = 7;//   视频节目表更新失败
   const CODE_CFG_FILE_ERROR = 8;//   配置文件错误
   const CODE_MD5_ERROR = 9;//   文件校验错误
   const CODE_PKG_ERROR = 10;//   更新包不完整
   const CODE_RECOVER_FAILED = 11;// 恢复失败
   const CODE_OTHER_ERROR = 12;// 其他错误
   const CODE_BACKUP_SUCCESS = 0;// 备份成功
   const CODE_BACKUPING = 1;// 正在备份
   const CODE_BACKUP_FAILURE = 2;// 备份失败
   const CODE_BACKUP_NO_DISK = 3;// 没有外挂硬盘

    const CODE_SUCCESS = 1;
    const CODE_FAILURE =0;

    const CODE_THIRD_ZERO =0;
    const CODE_THIRD_ONE =1;
    const CODE_THIRD_TWO =2;
    const CODE_THIRD_THREE =3;
    const CODE_THIRD_FOUR =4;
    const CODE_THIRD_FIVE =5;
    const CODE_THIRD_SIX =6;
    const CODE_THIRD_SEVEN =7;
    const CODE_THIRD_EIGHT =8;
    const CODE_THIRD_NINE =9;
    const CODE_THIRD_TEN =10;
    const CODE_THIRD_ELEVEN =11;
    const CODE_THIRD_TWELVE =12;
    const CODE_THIRD_THIRTEEN =13;
    const CODE_THIRD_FOURTEEN =14;
    const CODE_THIRD_FIFTEEN =15;
    const CODE_THIRD_SIXTEEN =16;




    /*******************************************命令常量******************************************/
    const CMD_USB_CHECK = 21;// 检测USB
    const CMD_DEVICE_STATUS = 0;//上报终端
    const CMD_DEVICE_VERSION = 1; // 查询部件版本信息
    const CMD_DEVICE_REBOOT = 3; // 部件重启
    const CMD_BITE = 13;// 自检
    const CMD_3G_CONTROAL = 30;// 查询或控制3G
    const CMD_QUERY_UPDATE = 32;// 查询更新包
    const CMD_QUERY_UDPATE_STATUS = 33;//查询更新状态
    const CMD_CONFIRM_UPDATE = 34;//确认更新
    const CMD_START_PROG_UPDATE = 48;//开始节目更新
    const CMD_START_SYS_UPDATE = 49;//开始系统更新
    const CMD_COMPLETE_UPDATE = 65;//结束更新
    const CMD_QUERY_WIFI_STATUS = 96;// 查询WIFI状态
    const CMD_SET_WIFI = 97;// 设置WIFI
    const CMD_SET_WIFI_switch = 98;// 设置WIFI
    const CMD_3G_DATA_SYNC = 99;// 3G数据同步
    const CMD_3G_DATA_SYNC_QUERY = 100;// 查询3G数据同步状态
    const CMD_EXPORT_DATA = 112;// 数据导出
    const CMD_IMPORT_DATA = 113;// 数据导入
    const CMD_QUERY_TEST_MODE = 114;// 查询WIFI调试模式
    const CMD_SET_TEST_MODE = 115;// 设置WIFI调试模式
    const CMD_SYNC_TIME = 130;// 时间校准
    const CMD_SET_AP_POWER = 133;// AP调试（上下电）
    const CMD_SCRN_CALIBRATE = 134;// 屏幕校准
    const CMD_SYS_BACKUP = 135;// 系统备份
    const CMD_SYS_BACKUP_QUERY = 136;// 系统备份查询
    const CMD_RESET = 144;// 恢复出厂设置
    const CMD_FTP_CHECK = 146;//检测FTP源服务器
    const CMD_SET_SN = 150;//设置生产序列号
    const CMD_SET_EM = 152;//设置设备型号
    const CMD_SWITCH_4G = 160;//4g开关
    const THIRD_CMD_TYPE1 = 1;
    const THIRD_CMD_TYPE2 = 2;
    const THIRD_CMD_TYPE3 = 3;
    const THIRD_CMD_TYPE5 = 5;
    const THIRD_CMD_TYPE10 = 10;
    const THIRD_CMD_TYPE11 = 11;
    const RESPONSE = 1;
    const THIRD_APP_UPDATE = 0;
    const THIRD_PROG_UPDATE = 1;
    const THIRD_DATA_EXPORT = 2;

    /********************************************设备类型常量*******************************************/
    const TARGET_ALL = 0;
    const TARGET_CMT = 3;
    const TARGET_SERVER = 4;
    const TARGET_ADB = 5;
    const TARGET_PDL = 11;
    const TARGET_PXY_MIPS = 12;
    const TARGET_APS = 13;
    const TARGET_CPE = 14;
    const TARGET_CAP2K = 15;
    const TARGET_3G_QUERY = 2;
    /********************************************更新常量*******************************************/

    const UPDATE_TYPE_PRG = 1;// USB节目更新
    const UPDATE_TYPE_SYS = 2;// 系统更新
    const UPDATE_TYPE_DEV = 3;// 部件更新
    const UPDATE_TYPE_PKG = 4;// 下载更新包
    const UPDATE_TYPE_BKP = 5;// 系统备份
    const UPDATE_TYPE_PDL = 6;// PDL节目更新
    const UPDATE_QUERY_ITEM_USB = 1;// USB节目更新
    const UPDATE_QUERY_ITEM_SYS = 2;// 系统更新
    const UPDATE_QUERY_ITEM_PDL = 3;// PDL节目更新
    /********************************************文件路径配置常量*******************************************/

    const UPDATE_SRC = '/usr/donica/update/';
    //const UPDATE_SRC = './';
    const VERSION_CFG_FILE = 'system_version_info.xml';
    const CURRENT_VERSION_SRC = '/usr/donica/update/system/';
    const MEDIA_MULTI_DISKINFO_FILE = '/usr/donica/conf/diskinfo.xml';
    const UPDATE_LOG_FILE = 'update_log.xml';
    const PROGRAM_CFG_FILE = 'update.xml';
    const UPDATE_DONE_SRC = '/usr/donica/update/back/';

    /********************************************表常量*******************************************/
    const CMT_ADMIN_USER = 'cmt_admin_user';
    const CMT_CABIN = 'cmt_cabin';
    const CMT_CONFIG = 'cmt_config';
    const CMT_CONTRY = 'cmt_contry';
    const CMT_DEMAND_INFO = 'cmt_demand_info';
    const CMT_ELITE_REQUIREMENTS = 'cmt_eliterequirments';
    const CMT_GOODS = 'cmt_goods';
    const CMT_GOODS_CATE = 'cmt_goods_cate';
    const CMT_INVESTIGATE = 'cmt_investigate';
    const CMT_MEMBER = 'cmt_member';
    const CMT_MEMBER_EXPORT = 'cmt_member_export';
    const CMT_MEMBER_TMP = 'cmt_member_tmp';
    const CMT_OPERATE = 'cmt_operate';
    const CMT_ORDER = 'cmt_order';
    const CMT_ORDER_DETAILS = 'cmt_order_details';
    const CMT_PLAY_FILES = 'cmt_play_files';
    const CMT_PPPOE_LOG = 'cmt_pppoe_log';
    const CMT_PRAM = 'cmt_pram';
    const CMT_RECEIVE_ADDRESS = 'cmt_receive_address';
    const CMT_SEAT = 'cmt_seat';
    const CMT_TASK = 'cmt_task';
    const CMT_TASK_INSTANCE = 'cmt_task_instance';
    const CMT_VA = 'cmt_va';
    const CMT_VERSION = 'cmt_version';
    const CMT_HNA_MEMBER_NUMBER = 'hnair_number';
    const OAM_AIRPLANE = 'oam_airplane';
    const OAM_ALARM_MESSAGE = 'oam_alarmmessage';
    const OAM_APPLICATION = 'oam_application';
    const OAM_AP_STATUS = 'oam_apstatus';
    const OAM_BITE_PARAM = 'oam_biteparam';
    const OAM_BITE_PARAM_VALUE = 'oam_biteparamvalue';
    const OAM_CALIBRATION_CONFIG = 'oam_calibrationconfig';
    const OAM_CALL_SERVICE = 'oam_callservice';
    const OAM_CONTENT = 'oam_content';
    const OAM_CONTENT_GROUP = 'oam_contentgroup';
    const OAM_DASHBOARD_INFO = 'oam_dashboard_info';
    const OAM_DEVICE = 'oam_device';
    const OAM_DEVICE_CATEGORY = 'oam_devicecategory';
    const OAM_DEVICE_DETAIL = 'oam_device_detail';
    const OAM_DINNER_SERVICE = 'oam_dinnerservice';
    const OAM_FLIGHT_INFO = 'oam_flightinfo';
    const OAM_FLIGHT_INFO_DETAIL = 'oam_flightinfodetail';
    const OAM_HARD_DISK_PARAM = 'oam_harddiskparam';
    const OAM_MAIL_DATA = 'oam_mail_data';
    const OAM_MAIL_USER = 'oam_mail_user';
    const OAM_MAIL_INFO = 'oam_mail_info';
    const OAM_MONITOR_PARAM = 'oam_monitorparam';
    const OAM_MONITOR_PARAM_VALUE = 'oam_monitorparamvalue';
    const OAM_PARAM_MAP = 'oam_param_map';
    const OAM_PARAM_TYPE = 'oam_paramtype';
    const OAM_PASSENGER_INFO = 'oam_passengerinfo';
    const OAM_PROXY_MAP = 'oam_proxymap';
    const OAM_SEAT_CONTENT = 'oam_seatcontent';
    const OAM_SEAT_GROUP = 'oam_seatgroup';
    const OAM_SEAT_GROUP_MEMBER = 'oam_seatgroupmember';
    const OAM_SEAT_GROUP_PRIVILEGE = 'oam_seatgroupprivilege';
    const OAM_TROUBLE_MESSAGE = 'oam_troublemessage';
    const OAM_TWLU_CONFIG = 'oam_twluconfig';
    const OAM_UPGRADE_SERVICE = 'oam_upgradeservice';
    const EPG_MOVIE_FILE = 'epg_movie_file';
    const EPG_TV_FILE = 'epg_tv_file';
    const EPG_MUSIC = 'epg_music';
    const EPG_VOICE_MSG_BOARD = 'epg_voice_messageboard';
    const EPG_WENJUAN_ANSWER = 'epg_wenjuan_answer';
    const EPG_WENJUAN_RESULT = 'epg_wenjuan_result';
    const CMT_AUTO_EXPORT = 'cmt_auto_export';


    /********************************************socket配置*******************************************/
    const DEFAULT_SOCKET_TIMEOUT = 20;// 默认socket超时时间
    const SOCKET_IP = '192.168.2.99';//定义socketIP
    //const SOCKET_IP = '127.0.0.1';//定义socketIP
    const SOCKET_PORT = '7890';//定义socket端口常
    const THIRD_SOCKET_PORT = '6780';//定义第三方升级端口
    const SOCKET_PORT_SIC = '8900';//SIC的socket端口
    const SOCKET_PORT_3G = '8300';//3g的socket端口

    /*******************************************更新包来源常量*******************************************/
    const COPY_FROM_USB = '0';//来源于USB
    const COPY_FROM_SVR = '1';//来源于服务器
    const COPY_FROM_PDL = '3';//来源于PDL

    /*******************************************Ap模式常量*******************************************/
    const AP_MODE_APS =1;
    const AP_MODE_CAP2K =2;
    const AP_MODE_KONTRON =3;
    const AP_MODE_DEFAULT =2;
    const PLUGIN_CMT =0;
    const PLUGIN_ADB =1;
    const PLUGIN_CPE =1;


    /*******************************************设备分类常量*******************************************/
    const DEV_TYPE_ALL =0;
    const DEV_TYPE_CMT =3;
    const DEV_TYPE_SERVER =4;
    const DEV_TYPE_ADB =5;
    const DEV_TYPE_APS =13;
    const DEV_TYPE_CPE =14;
    const DEV_TYPE_CAP =15;
    const DEV_TYPE_KU =15;
    const DEV_TYPE_TWLU =17;
    const DEV_TYPE_CAP_KONTRON =18;


    /*******************************************自检参数常量*******************************************/
    const PT_RUNNING_STATE =1;
    const PT_RUNNING_TIME =2;
    const PT_CPU_IDLE =3;
    const PT_MEM_TOTAL =4;
    const PT_MEM_FREE =5;
    const PT_CPU_TEMP =6;
    const PT_SYS_TEMP =7;
    const PT_AC_NAME =8;
    const PT_AC_MODEL =9;
    const PT_AC_VERSION =10;
    const PT_UP_TIME =11;
    const PT_MAX_AP_LIMIT =12;
    const PT_MAX_CLIENT_LIMIT =13;
    const PT_INSTALLED_LICENSES =14;
    const PT_IN_USE_LICENSES =15;
    const PT_AP_ONLINE =16;
    const PT_AP_OFFLINE =17;
    const PT_USER_WLAN =18;
    const PT_USER_WLAN_2DOT4G =19;
    const PT_USER_WLAN_5G =20;
    const PT_USER_LAN =21;
    const PT_ALARM_TOTAL =22;
    const PT_ALARM_CRIT =23;
    const PT_ALARM_MAJOR =24;
    const PT_ALARM_MINOR =25;
    const PT_ROGUE_APS =26;
    const PT_ROGUE_STATIONS =27;
    const PT_ROGUE_UNKNOWN_DEV =28;
    const PT_CLEAR_ESS_PROFILE =29;
    const PT_SECURE_ESS_PROFILE =30;
    const PT_CAPTIVE_PORTAL_ESS_PROFILE =31;
    const PT_3G_STATUS =32;
    const PT_CABIN_DOOR_STATUS =33;
    const PT_WOW_STATUS =34;
    const PT_PA_STATUS =35;
    const PT_WLAN_RECV =36;
    const PT_WLAN_SEND =37;
    const PT_3G_IP =38;
    const PT_AUB_LOAD_VER =39;
    const PT_RFU_LOAD_VER =40;
    const PT_RFU_RF_CALIB =41;
    const PT_CPE_UPTIME =42;
    const PT_CPE_STATUS =43;
    const PT_CPE_PUBLIC_IP =44;
    const PT_RECV_BYTES =45;
    const PT_SEND_BYTES =46;
    const PT_CPE_IP =56;
    const PT_CPE_MAC =57;
    const PT_CONN_STATUS =67;
    /*******************************************加密方式参数常量*******************************************/
    const SECURE_MODE_OPEN =0; // 开放
    const SECURE_MODE_WAP_PSK =1; // WAP_PSK
    const SECURE_MODE_WAP2_PSK =2;// WAP2_PSK
    /*******************************************CPE自检结果常量*******************************************/
    const CPE_BITE_NOT_YET =0;// 尚未自检
    const CPE_BITE_IN_PROC =1;// 正在
    const CPE_BITE_FAILED =2;// 自检失败
    const CPE_BITE_SUCCESS =3;// 自检成功
 /*******************************************自检类型结果常量*******************************************/
     const BITE_GROUP_APP =1;
     const BITE_GROUP_OS =2;
     const BITE_GROUP_ACINFO =4;
     const BITE_GROUP_AIRPLANE =8;
     const BITE_GROUP_HARDDISK =16;
     const BITE_GROUP_APINFO =32;
     const BITE_GROUP_CPE =128;
     const DEV_INFO_DEV =1;
     const DEV_INFO_SUB_DEV =2;
     const DEV_INFO_APP =3;
     const DEV_INFO_HARDDISK =4;
     const DEV_INFO_PHYSIC =5;
     const DEV_INFO_STATUS =6;

    /*******************************************数据导出常量*******************************************/

    const FT_EXCEL = 1;
    const FT_XML = 2;
    const FT_CSV = 3;


 /*******************************************自检相关常量*******************************************/
 const DIAGNOSE_STATUS_IDLE = 0;
 const DIAGNOSE_STATUS_PROCESSING = 1;
 const DIAGNOSE_STATUS_NORMAL = 2;
 const DIAGNOSE_STATUS_ABNORMAL = 3;
 const DIAGNOSE_STATUS_FAILED = 4;
 const DIAGNOSE_STATUS_NAME = 'bite_statue' ;
 const DIAGNOSE_TYPE_4G = 1 ;
 const DIAGNOSE_TYPE_WIFI = 2 ;
 const DIAGNOSE_TYPE_DEVICE = 3 ;
 const CAP_STATUS_ABNORMAL = 1 ;
 const CAP_STATUS_FAILED = 2 ;


 const W4G_ERR_NONE = 0 ;
 const W4G_ERR_DIAL_FAILED = 1 ;
 const W4G_ERR_NOT_FOUND_DIAL_LOG = 2 ;
 const W4G_ERR_RECV_AT_CMD_FAILED = 3;
 const W4G_ERR_SIM_NONE = 4 ;
 const W4G_ERR_NO_SIGNAL = 5 ;
 const W4G_ERR_OUT_OF_SERVICE = 6 ;
 const W4G_ERR_UNKNOWN = 7 ;
 const W4G_ERR_SWITCH_CLOSE = 8;

 const W4G_ERR_DIAL_FAILED_CODE = 4;//拨号失败状态码
 const W4G_ERR_SIM_CARD_NOT_FOUND_CODE = 2;//sim卡不在
 const W4G_ERR_NO_SIGNAL_CODE = 1;//信号弱
 const W4G_ERR_SWITCH_CLOSE_CODE = 3;//开关


/*
0：W4G_ERR_NONE,
1：W4G_ERR_DIAL_FAILED,
2：W4G_ERR_NOT_FOUND_DIAL_LOG,
3：W4G_ERR_RECV_AT_CMD_FAILED,
4：W4G_ERR_SIM_NONE,
5：W4G_ERR_NO_SIGNAL,
6：W4G_ERR_OUT_OF_SERVICE,
7：W4G_ERR_UNKNOWN,*/


 const APP_CONFIG_XML = '/usr/donica/app/config.xml' ;
 const APP_CONFIG_INI = '/usr/donica/app/config.ini';
 const DEFAULT_HEIGHT_THREHOLD = 10000;


}
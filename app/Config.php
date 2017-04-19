<?php

namespace App;

use App\Http\Service\Consts;
use Illuminate\Support\Facades\Crypt;
use App\Http\Service\Log\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use app\Http\Service\Tools\EmailHelper;
use app\Http\Service\Tools\NetTool;


define("DIAGNOSE_STATUS_IDLE", 0); // 尚未开始检测
define("DIAGNOSE_STATUS_PROCESSING", 1); // 正在检测
define("DIAGNOSE_STATUS_NORMAL", 2); // 系统正常
define("DIAGNOSE_STATUS_ABNORMAL", 3); // 系统异常
define("DIAGNOSE_STATUS_FAILED", 4); // 系统故障


define("STATUS_WIFI", 'WiFi'); // WiFi
define("STATUS_KU", 2); // Ku
define("STATUS_4G", '4G'); // 4G
define("STATUS_WOW", 'WoW'); // WOW
define("STATUS_PA", 'PA'); // PA
define("STATUS_ATG", 'ATG'); // ATG
define("STATUS_ONLINE_USERS", 'OnlineUsers'); // Online Users
define("STATUS_DOOR", 'Door'); // door status
define("STATUS_LAN", 'LAN'); // door status
define("STATUS_USB", 'USB'); // door status
define("STATUS_4GSWITCH", '4GSWITCH'); // door status
define("STATUS_WIFISWITCH", 'WIFISWITCH'); // door status
class Config extends Model
{
    protected $table = 'cmt_config';

    /**
     * @return mixed
     * 获取一键自检的状态标识
     */
    public function getDiagnoseStatus()
    {
        $data = DB::table('cmt_config')->where('var_name', 'bite_statue')->first();
        $diagnose_status = $data->var_value;
        return $diagnose_status;
    }

    /**
     * @return mixed
     * 获取系统的错误信息
     */
    public function getTroubleMessageList($status)
    {
        $list = DB::table('oam_troublemessage')
            ->where('Visible', '1')
            ->get();
        return $list;
    }

    /**
     * @param $status
     * @return mixed
     * define ( "DIAGNOSE_STATUS_IDLE", 0 ); // 尚未开始检测
     * define ( "DIAGNOSE_STATUS_PROCESSING", 1 ); // 正在检测
     * define ( "DIAGNOSE_STATUS_NORMAL", 2 ); // 系统正常
     * define ( "DIAGNOSE_STATUS_ABNORMAL", 3 ); // 系统异常
     * define ( "DIAGNOSE_STATUS_FAILED", 4 ); // 系统故障
     * 根据状态获取自检的信息
     */
    public function getDiagnoseMessage($status)
    {
        switch ($status) {
            case DIAGNOSE_STATUS_IDLE :
                $status_message = trans("尚未开始检测");
                break;

            case DIAGNOSE_STATUS_PROCESSING :
                $status_message = trans("检测中......");
                break;

            case DIAGNOSE_STATUS_NORMAL :
                $status_message = trans("系统运行正常");
                break;

            case DIAGNOSE_STATUS_ABNORMAL :
                $status_message = trans("系统运行异常");
                break;

            case DIAGNOSE_STATUS_FAILED :
                $status_message = trans("系统故障");
                break;
        }
        return $status_message;
    }

    /**
     * @return array
     * 获取登录页面的一些状态及参数
     */
    public function getStatus()
    {
        $stat_list = array(
            "WIFI",
            "4G",
            "WoW",
            "PA",
            "ATG",
            "Door",
            "LAN",
            "USB",
            "Online_Users",
            "4GSwitch",
            "WifiSwitch",
        );

        $status = array();
        foreach ($stat_list as $name) {
            $cons_name = strtoupper(sprintf("status_%s", $name));
            $key = strtolower($cons_name);
            $status [$key] = $this->_getStatus(constant($cons_name));
        }
        return $status;
    }


    /**
     * @param $type
     * @return int
     * // 状态栏状态
     * define ( "STATUS_WIFI", 1 ); // WiFi
     * define ( "STATUS_KU", 2 ); // Ku
     * define ( "STATUS_4G", 3 ); // 4G
     * define ( "STATUS_TWLU", 4 ); // TWLU
     * define ( "STATUS_WOW", 5 ); // WOW
     * define ( "STATUS_PA", 6 ); // PA
     * define ( "STATUS_ATG", 7 ); // ATG
     * define ( "STATUS_ONLINE_USERS", 8 ); // Online Users
     * define ( "STATUS_3G_ERR_CODE", 9 ); // 3G module State Error Code
     * define ( "STATUS_DOOR", 10 ); // door status
     */
    public function _getStatus($type)
    {
        switch ($type) {
            case STATUS_4G :
            case STATUS_WOW :
            case STATUS_PA :
            case STATUS_ATG :
            case STATUS_DOOR :
            case STATUS_LAN :
            case STATUS_USB :
            case STATUS_4GSWITCH :
            case STATUS_WIFISWITCH:
                $status = $this->getPublicStatus($type);
                break;

            case STATUS_ONLINE_USERS :
                $status = $this->getOnlineUsers();
                break;
            case STATUS_WIFI :
                $status=$this->getWifiStatus();
                break;
            default :
                $status = 0;
                break;
        }
        return $status;
    }

    public function getWifiStatus()
    {
        //读出3个cap状态
        $status = 1;
        $status_list = $this->getCapStatus();
        if (count($status_list)) {
            foreach ($status_list as $device) {
                if ($device->DevStatus == 2) {
                    $status = 1;
                    break;
                }
                $status = 0;
            }
        } else {
            $status = 0;
        }
        return $status;
    }

    /**
     * @return mixed
     * 读出三个cap状态
     */
    public function getCapStatus()
    {
        $sql = "select * from " . Consts::OAM_DEVICE . "  where DevType='15'";
        $status = DB::select($sql);
        return $status;
    }

    public function getPublicStatus($type)
    {
        $dash_info = $users = DB::table('oam_dashboard_info')->where([
            ['Available', '=', '1'],
            ['Name', '=', $type],
        ])->first();
        if ($dash_info->Value == '1') {
            return $status = 1;
        } else {
            return $status = 0;
        }
    }

    /**
     * @return mixed
     * 获取当前在线人数
     */
    public function getOnlineUsers()
    {
        $dash_info = $users = DB::table('oam_dashboard_info')->where('Name', 'OnlineUsers')->first();
        return $dash_info->Value;
    }


    /**
     * @return mixed
     * 获取收件人列表
     */
    public function getReceiverList()
    {
        $receiverList = DB::table('oam_mail_info')
            ->join('cmt_task', 'oam_mail_info.MailType', '=', 'cmt_task.TaskDesc')
            ->where('Active', '1')
            ->select('oam_mail_info.MailType', 'oam_mail_info.UserID', 'oam_mail_info.Subject', 'cmt_task.TaskID')
            ->get();
        return $receiverList;
    }

    /**
     * @param $type
     * @return mixed
     * 通过收件人邮箱地址获取邮件类别
     */
    public function getReceiverByMailType($type)
    {
        $receiver = DB::table('oam_mail_info')
            ->where('MailType', $type)
            ->first();
        return $receiver;
    }

    /**
     * @param $MailType
     * @param $user_id
     * @return mixed
     * 更新收件人邮箱地址
     */
    public function updateReceiver($MailType, $user_id)
    {
        $result = DB::table('oam_mail_info')
            ->where('MailType', $MailType)
            ->update(['UserID' => $user_id]);
        return $result;
    }

    /**
     * @return mixed
     * 获取发件人信息列表
     */
    public function getSenderList()
    {
        $result = DB::table('oam_mail_user')
            ->get();
        return $result;
    }

    /**
     * @param $user_id
     * @return mixed
     * 通过邮箱地址获取发件人邮箱配置信息
     */
    public function getSenderByUserId($user_id)
    {
        $sender = DB::table('oam_mail_user')
            ->where('UserID', $user_id)
            ->first();
        return $sender;
    }

    /**
     * @param $user_id
     * @param $pwd
     * @param $smtpsvr
     * @param $port
     * @return mixed
     * 更新发件人邮箱配置信息
     */
    public function updateSender($user_id, $pwd, $smtpsvr, $port)
    {
        $result = DB::table('oam_mail_user')
            ->where('UserID', $user_id)
            ->update(['UserID' => $user_id,
                'Pwd' => $pwd,
                'SmtpSvr' => $smtpsvr,
                'Port' => $port]);
        return $result;
    }

    /**
     * @return mixed
     * 获取用户列表信息
     */
    public function getUserList()
    {
        $result = DB::table('cmt_admin_user')
            ->get();
        return $result;
    }

    /**
     * @param $user_type
     * @return mixed
     * 通过用户类别获取用户信息
     */
    public function getUserByUserType($user_type)
    {
        $user = DB::table('cmt_admin_user')
            ->where('type', $user_type)
            ->first();
        return $user;
    }

    /**
     * @param $user_type
     * @param $new_password
     * @return mixed
     * 更新用户信息
     */
    public function updateUser($user_type, $new_password)
    {
        $password = $new_password;
        $result = DB::table('cmt_admin_user')
            ->where('type', $user_type)
            ->update(['password' => $password]);
        return $result;
    }

    /**
     * @return mixed
     * 通过升级方式获取该升级方式的升级参数
     */
    public function getUsbConfigInfoByUpgradeMethod()
    {
        $result = DB::table('oam_ftp_info')
            ->where('type', 1)
            ->first();
        return $result;
    }

    /**
     * @param $type
     * @param $url
     * @param $username
     * @param $password
     * @return mixed
     * 更新USB系统升级的参数
     */
    public function updateSystemUpgradeUsbConfig($type = 1, $url, $username, $password)
    {
        $result = DB::table('oam_ftp_info')
            ->where('type', $type)
            ->update(['url' => $url,
                'username' => $username,
                'passwd' => $password]);
        return $result;
    }

    /**
     * @param $name
     * @return mixed
     * 获取系统序列号
     */
    public function getSystemIdByName($name)
    {
        $result = DB::table('cmt_config')
            ->where('var_name', $name)
            ->first();
        return $result;
    }

    /**
     * @param $system_id
     * @return mixed
     * 更新系统序列号
     */
    public function updateSystemId($system_id)
    {
        $result = DB::table('cmt_config')
            ->where('var_name', "system_id")
            ->update(['var_value' => $system_id]);
        return $result;
    }

    public function getCapReplaceValue()
    {
      $result= $this->getSystemIdByName("cap_replace");
        return $result;
    }

    /**
     * @return array
     * 得到一些飞行数据
     * 飞行高度，飞行经度，飞行纬度，飞行速度
     */
    public function getSomeFlightData()
    {
        $flightDatas = array("Altitude", "AirSpeed", "Latitude", "Longitude");
        foreach ($flightDatas as $flightData) {
            $result[] = DB::table('oam_dashboard_info')
                ->where('Name', $flightData)
                ->get();
        }
        return $result;
    }

    /**
     * @param $err_type
     * @param $err_code
     * @param $err_msg
     * @return mixed
     * 将得到的错误消息记录到cmt_diagnosis_result
     */
    public function getTroubleMessageTo($err_type, $err_code, $err_msg)
    {
        $now_time = date("Y-m-d H:i:s", time());
        $result = DB::table('cmt_diagnosis_result')->insert(
            [
                'err_time' => $now_time,
                'err_code' => $err_code,
                'err_msg' => $err_msg,
                'err_type' => $err_type
            ]
        );
        return $result;
    }

    public function getFtpVersion()
    {
        $result = DB::table('cmt_config')
            ->where('var_name', "ftp_latest_version")
            ->first();
        return $result;
    }

    public function getFtpVersionFlag()
    {
        $result = DB::table('cmt_config')
            ->where('var_name', "ftp_upgraded_flag")
            ->first();
        return $result;
    }


    public function getServerConfigInfo()
    {
        $result = DB::table('cmt_version')
            ->where('DevType', 4)
            ->select('DevPosition', 'DevSeq', 'DevModel')
            ->first();
        return $result;
    }

    public function getNetWorkMode(){
        $result = DB::table('cmt_config')
            ->where('var_name', "caps_network_mode")
            ->first();
        return $result;
    }
    public function updateNetWorkMode($mode){
        $result = DB::table('cmt_config')
            ->where('var_name', "caps_network_mode")
            ->update(['var_value' => $mode]);
        return $result;
      }
    public function updateServerConfig($type = 4, $server_sn, $server_em)
    {
        $result = DB::table('cmt_version')
            ->where('DevType', $type)
            ->update(['DevSeq' => $server_sn,
                'DevModel' => $server_em]);
        return $result;
    }

    public function getCapConfigInfo()
    {
        $result = DB::table('cmt_version')
            ->where('DevType', 15)
            ->select('DevPosition', 'DevSeq', 'DevModel')
            ->get();
        return $result;
    }

    public function updateCapSnAndModConfig($cap_sn1, $cap_em1, $cap_sn2, $cap_em2, $cap_sn3, $cap_em3)
    {
        $result[] = DB::table('cmt_version')
            ->where('DevPosition', '0-ap-1')
            ->update(
                ['DevSeq' => $cap_sn1,
                    'DevModel' => $cap_em1]
            );

        $result[] = DB::table('cmt_version')
            ->where('DevPosition', '0-ap-2')
            ->update(
                ['DevSeq' => $cap_sn2,
                    'DevModel' => $cap_em2]
            );

        $result[] = DB::table('cmt_version')
            ->where('DevPosition', '0-ap-3')
            ->update(
                ['DevSeq' => $cap_sn3,
                    'DevModel' => $cap_em3]
            );

        return $result;
    }


    public function validateSender($userId)
    {
        $sender = $this->getSenderByUserID($userId);
        $email_helper = new EmailHelper ($sender ["UserID"], $sender ["Pwd"], $sender ["SmtpSvr"], $sender ["Port"]);
        $net_tool = new NetTool();
        define("CNSU_IP", "192.168.2.99");
        $error_code = $net_tool->addRoute(CNSU_IP);
        Log::write("add route gateway : " . CNSU_IP . " " . ($error_code ? "failed" : "success"), Log::DEBUG, Log::FILE);
        Log::write("validate smtp " . print_r($sender, true), Log::DEBUG, Log::FILE);
        $result = $email_helper->validateSMTP();
        Log::write("validate email " . ($result ? "success" : "failed"), Log::DEBUG, Log::FILE);
        $error_code = $net_tool->delRoute(CNSU_IP);
        Log::write("del route gateway : " . CNSU_IP . " " . ($error_code ? "failed" : "success"), Log::DEBUG, Log::FILE);
        return $result;
    }


}

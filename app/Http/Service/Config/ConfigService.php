<?php
namespace App\Http\Service\Config;

use App\Http\Service\Base\BaseService;
use App\Http\Service\Consts;
use App\Http\Service\Db\DBHelper;
use App\Http\Service\Tcp\CommandHelper;
use Illuminate\Support\Facades\DB;

class ConfigService extends BaseService
{
    private $context_items = array (
        "飞机[system_id]从开始时间(start_time)到结束时间(end_time)的日志。",
        "从开始时间(start_time)到结束时间(end_time)的日志。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)WiFi的用户操作信息。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)WiFi的用户行为统计信息。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)通过WiFi填写的意见卡信息。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)通过WiFi填写的留言板信息。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)通过WiFi填写的调查问卷信息。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)通过WiFi填写的贵宾会员需求信息。",
        "飞机[system_id] 从开始时间(start_time)到结束时间(end_time)通过WiFi注册的会员信息。",
        "深圳市多尼卡电子技术有限公司",
        "深圳市南山区智恒产业园1栋5楼",
        "深圳市南山区南头关口二路智恒产业园1栋",
        "邮编：518000",
        "邮编：518057",
        "电话：+86-755-26983727",
        "传真：+86-755-26013757",
        "邮箱：techsupports@donica.cn",
        "主页：www.donica.com"
    );

    public function screenCalibrate() {
        $result = CommandHelper::sendCommand ( Consts::CMD_SCRN_CALIBRATE, TARGET_CMT, '', false );
        return $result;
    }

    public function getApByID($id) {
        $sql = "SELECT * FROM " . Consts::OAM_AP_STATUS . " WHERE ID = '$id' LIMIT 1";
        return DBHelper::getOne ( $sql );
    }

    public function saveAP($params) {
        if (is_array ( $params )) {
            $columns = array ();
            $values = array ();
            foreach ( $params as $key => $value ) {
                $columns [] = $key;
                $values [] = sprintf ( "'%s'", $value );
            }
            $sql = "REPLACE INTO " .Consts:: OAM_AP_STATUS . " ( " . implode ( ',', $columns ) . " ) VALUES ( " . implode ( ',', $values ) . " )";
            return DBHelper::saveOrUpdate ( $sql );
        } else {
            return false;
        }
    }

    public function updateAP($params) {
        if (is_array ( $params )) {
            $id = $params ["ID"];
            $name = $params ["Name"];
            $ip = $params ["IPAddress"];
            $mac = $params ["Mac"];
            $sql = "UPDATE " . Consts::OAM_AP_STATUS . " SET Name = '$name', IPAddress = '$ip', Mac = '$mac' WHERE ID = '$id'";
            DBHelper::saveOrUpdate ( $sql );
            return true;
        } else {
            return false;
        }
    }

    public function deleteAP($id) {
        if (empty ( $id )) {
            return false;
        } else {
            $sql = "DELETE FROM " . Consts::OAM_AP_STATUS . " WHERE ID = '$id'";

            return DBHelper::delete ( $sql );
        }
    }

    public function getTwluList($page) {
        // 查询总数的sql
        $count_sql = "SELECT COUNT(ID) FROM " . Consts::OAM_TWLU_CONFIG;
        // 查询数据的sql
        $query_sql = "SELECT * FROM " . Consts::OAM_TWLU_CONFIG . " ORDER BY SSID";
        // 查询一页数据
        $result = $this->getPageList ( $count_sql, $query_sql, $page, DEFAULT_ROWS_PER_PAGE, 'formatTwlu' );
        return $result;
    }

    public function formatTwlu($list, $param) {
        foreach ( $list as $key => $value ) {
            $list [$key] ['SecureMode'] = Formatter::formatSecureMode ( $list [$key] ['SecureMode'] );
        }
    }

    public function getTwluByID($id) {
        $sql = "SELECT * FROM " . Consts::OAM_TWLU_CONFIG . " WHERE ID = '$id' LIMIT 1";
        $twlu = DBHelper::getOne ( $sql );
        return $twlu;
    }

    public function saveOrUpdateTwlu($params) {
        if (is_array ( $params )) {
            $columns = array ();
            $values = array ();
            foreach ( $params as $key => $value ) {
                $columns [] = $key;
                $values [] = sprintf ( "'%s'", $value );
            }
            $sql = "REPLACE INTO " . Consts::OAM_TWLU_CONFIG . " ( " . implode ( ',', $columns ) . " ) VALUES ( " . implode ( ',', $values ) . " )";
            return DBHelper::saveOrUpdate ( $sql );
        } else {
            return false;
        }
    }

    public function deleteTwlu($id) {
        if (empty ( $id )) {
            return false;
        } else {
            $sql = "DELETE FROM " .Consts:: OAM_TWLU_CONFIG . " WHERE ID = '$id'";

            return DBHelper::delete ( $sql );
            ;
        }
    }

    public function getSenderList() {
        $sql = "SELECT * FROM " . Consts::OAM_MAIL_USER;
        $list = DBHelper::getList ( $sql );
        return $list;
    }

    public function getSenderByUserID($userId) {
        $sql = "SELECT * FROM " . Consts::OAM_MAIL_USER . " WHERE UserID = '$userId' LIMIT 1";
        return DBHelper::getOne ( $sql );
    }

    public function getTopOneSender() {
        $sql = "SELECT * FROM " . Consts::OAM_MAIL_USER . " LIMIT 1";
        return DBHelper::getOne ( $sql );
    }

    public function updateSender($params) {
        if (is_array ( $params )) {
            //delete all history data
            $sql = "TRUNCATE ".Consts::OAM_MAIL_USER;
            DBHelper::delete($sql);

            $keys = array (
                "UserID",
                "Pwd",
                "SmtpSvr",
                "Port"
            );
            $values = array ();

            foreach ( $keys as $key ) {
                $values [] = "'" . $params [$key] . "'";
            }

            $sql = "REPLACE INTO " . Consts::OAM_MAIL_USER . " (" . implode ( ',', $keys ) . ") VALUES(" . implode ( ',', $values ) . ")";
            return DBHelper::saveOrUpdate ( $sql );
        } else {
            return false;
        }
    }

    public function validateSender($userId) {
        $sender = $this->getSenderByUserID ( $userId );

        include_once 'lib/Tools/EmailHelper.php';
        include_once 'lib/Tools/NetTool.php';

        $email_helper = new EmailHelper ( $sender ["UserID"], $sender ["Pwd"], $sender ["SmtpSvr"], $sender ["Port"] );
        $net_tool = new NetworkTool ();

        $error_code = $net_tool->addRoute ( CMT_IP );
        Log::write ( "add route gateway : " . CMT_IP . " " . ($error_code ? "failed" : "success"), Log::DEBUG, Log::FILE );

        Log::write ( "validate smtp " . print_r ( $sender, true ), Log::DEBUG, Log::FILE );
        $result = $email_helper->validateSMTP ();
        Log::write ( "validate email " . ($result ? "success" : "failed"), Log::DEBUG, Log::FILE );

        $error_code = $net_tool->delRoute ( CMT_IP );
        Log::write ( "del route gateway : " . CMT_IP . " " . ($error_code ? "failed" : "success"), Log::DEBUG, Log::FILE );

        return $result;
    }

    public function getRecverList() {
        // 查询总数的sql
        $count_sql = "SELECT COUNT(MailType) FROM " . OAM_MAIL_INFO . " INNER JOIN " . CMT_TASK . " ON MailType = TaskDesc WHERE Active = 1";
        // 查询数据的sql
        $query_sql = "SELECT MailType, UserID, Subject FROM " . OAM_MAIL_INFO . " INNER JOIN " . CMT_TASK . " ON MailType = TaskDesc WHERE Active = 1";
        // 查询一页数据
        $result = $this->getPageList ( $count_sql, $query_sql, 1, DEFAULT_ROWS_PER_PAGE );
        return $result;
    }

    public function getRecverByMailType($mail_type) {
        $sql = "SELECT MailType, UserID, Subject, Context FROM " . OAM_MAIL_INFO . " WHERE MailType = '$mail_type' LIMIT 1";
        $recver = DBHelper::getOne ( $sql );
        $context = $recver ["Context"];
        foreach ( $this->context_items as $item ) {
            $context = str_replace ( $item, Trans::t ( $item ), $context );
        }
        $recver ["Context"] = $context;
        return $recver;
    }

    public function updateRecver($mail_type, $userId) {
        $sql = "UPDATE " . OAM_MAIL_INFO . " SET UserID = '$userId' WHERE MailType = '$mail_type'";
        return DBHelper::saveOrUpdate ( $sql );
    }

    public function saveMailData($data) {
        return DBHelper::save ( OAM_MAIL_DATA, $data );
    }

    public function getMailDataList() {
        $sql = "SELECT MailState FROM " . OAM_MAIL_DATA;
        return DBHelper::getList ( $sql );
    }

    public function syncTime($param) {
        $current_time = $param ["current_time"];
        $result = CommandHelper::sendCommand (Consts::CMD_SYNC_TIME, Consts::TARGET_SERVER, array (
            "mode" => 2,
            "correctTime" => $current_time
        ) );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $result ["code"] =Consts:: CODE_SUCCESS;

           /*     if (getFilterGroup () == "wifi_ca") {
                    // 重置cacti最后运行时间
                    $service = new CactiService ();
                    $service->resetPollerLastRunTime ( $current_time );
                }*/
                // 删除比当前时间晚的历史数据
                $this->_clearHistoryData ( $current_time );
                // 保存同步时间记录
                $this->_saveTimeSync ( $param );
                break;

            default :
                $result ["code"] = Consts::CODE_FAILURE;
                break;
        }
        return $result;
    }

    private function _clearHistoryData($current_time) {
        // 告警日志
        $this->_clearHistoryTableData ( Consts::OAM_ALARM_MESSAGE, $current_time, 'AlarmOccurTime' );
        // 硬盘自检日志
        $this->_clearHistoryTableData ( Consts::OAM_HARD_DISK_PARAM, $current_time );
        // 运行日志
        $this->_clearHistoryTableData ( Consts::OAM_MONITOR_PARAM_VALUE, $current_time );
        // 操作日志
        $this->_clearHistoryTableData ( Consts::CMT_OPERATE, $current_time, 'operate_time' );
    }

    private function _clearHistoryTableData($table_name, $current_time, $column = 'CreateTime') {
        $sql = "DELETE FROM " . $table_name . " WHERE $column >= '$current_time'";
        DB::delete ( $sql );

    }

    private function _saveTimeSync($param) {
        $now = date ( "Y-m-d H:i:s", time () );
        $current_time = $param ["current_time"];
        $data = array (
            'CalibrationMode' => '2', // 1:自动，2:手动;
            'Source' => '', // 时间来源
            'InitailTime' => "$now", // 初始时间
            'CalibrationTime' => "$current_time"  // 修改时间
        );
        DBHelper::save ( Consts::OAM_CALIBRATION_CONFIG, $data );
    }
    public function reboot($target, $position = "ALL:ALL") {
        $result = CommandHelper::sendCommand ( Consts::CMD_DEVICE_REBOOT, $target, $position, false );
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $result ["code"] = Consts::CODE_SUCCESS;
                break;

            default :
                //$result ["msg"] = Trans::t ( "重启失败！" );
                $result ["msg"] = "重启失败！";
                $result ["code"] = Consts::CODE_FAILURE;
                break;
        }
        return $result;
    }
    public function getSysconfigValue($name) {
        $sql = "SELECT var_value FROM " . CMT_CONFIG . " WHERE var_name = '$name' LIMIT 1";
        $row = DBHelper::getOne ( $sql );
        return $row ["var_value"];
    }

    public function updateSysconfigValue($name, $value) {
        $sql = "UPDATE " . CMT_CONFIG . " SET var_value = '$value' WHERE var_name = '$name' LIMIT 1";
        return DBHelper::saveOrUpdate ( $sql );
    }

    //设置SN的值
    public function setSnValue($CMD_SET,$dev_type, $site, $sn = '') {
        $params = array (
            "site" => $site,
            "sn" => $sn
        );
        $result = CommandHelper::sendCommand ( $CMD_SET, $dev_type, $params );
        return $result;
    }

    public function setModValue($CMD_SET,$dev_type, $site, $modnum = '') {
        $params = array (
            "site" => $site,
            "modnum" => $modnum
        );
        $result = CommandHelper::sendCommand ( $CMD_SET, $dev_type, $params );
        return $result;
    }

    //查询SN的值
    public function getValue($dev_type) {
        $result = CommandHelper::sendCommand ( CMD_SELECT_SN, $dev_type );
        return $result;
    }

    public function updateDevSeqValue($name, $value) {
        $sql = "UPDATE " . Consts::CMT_VERSION . " SET DevSeq = '$name' WHERE DevPosition = '$value' LIMIT 1";
        return DBHelper::saveOrUpdate ( $sql );
    }

    public function updateDevModValue($name, $value) {
        $sql = "UPDATE " . Consts::CMT_VERSION . " SET DevModel = '$name' WHERE DevPosition = '$value' LIMIT 1";
        return DBHelper::saveOrUpdate ( $sql );
    }

    public function selectSeqAndModValue($name) {
        $sql = "SELECT DevSeq ,DevModel FROM " . Consts::CMT_VERSION . " WHERE DevPosition = '$name' LIMIT 1";
        $result = DBHelper::getOne ( $sql );
        return $result;
    }

    public function getThirdValue($type) {
        $sql = "SELECT url ,username , passwd FROM " . OAM_FTP_INFO . " WHERE type = $type LIMIT 1";
        $result = DBHelper::getOne ( $sql );
        return $result;
    }

    public function updateThirdValue($url,$username,$passwd,$type) {
        $sql = "UPDATE " . OAM_FTP_INFO . " SET url = '$url', username = '$username', passwd = '$passwd' WHERE type = $type";
        return DBHelper::saveOrUpdate ( $sql );
    }

    public function getTransportProtocol() {
        $protocol = $this->getCheckedProtocol()[0];
        // 默认选中的传输方式
        $transWays = array (
            Consts::TRANS_WAY_SMTP => ($protocol->export_protocol==3 ? 1 : 0),    //($protocol==3 ? 1 : 0)
            Consts::TRANS_WAY_FTP => ($protocol->export_protocol==4 ? 1 : 0)
           // Consts:: TRANS_WAY_SFTP => ($protocol->export_protocol==20 ? 1 : 0)
        );

        $result = array ();
        foreach ( $transWays as $key => $value ) {
            $result [$key] ["text"] = $this->_getTransportProtocolText ( $key );
            $result [$key] ["checked"] = $value;
        }
        return $result;
    }

    private function _getTransportProtocolText($way) {
        switch ($way) {
            case Consts::TRANS_WAY_SMTP :
                $text = "SMTP";
                break;

            case Consts::TRANS_WAY_FTP :
                $text = "FTP";
                break;

            case Consts::TRANS_WAY_SFTP :
                $text = "SFTP";
                break;

            default :
                $text = "";
                break;
        }
        return $text;
    }

    public function getExportMethod() {
        $format = $this->getCheckedFormat()[0];
        // 默认选中的传输方式
        $transWays = array (
           Consts:: FT_EXCEL => ($format->export_format==1 ? 1 : 0),
         //  Consts:: FT_XML => ($format->export_format==2 ? 1 : 0),
//            Consts::FT_CSV => ($format->export_format==3 ? 1 : 0)
        );
        $result = array ();
        foreach ( $transWays as $key => $value ) {
            $result [$key] ["text"] = $this->_getExportMethodText ( $key );
            $result [$key] ["checked"] = $value;
        }
        return $result;
    }

    private function _getExportMethodText($way) {
        switch ($way) {
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

    public function getExportList() {
        $sql = "SELECT export_url,export_username,export_password FROM " . Consts::CMT_AUTO_EXPORT . " WHERE export_id = 1 LIMIT 1";
       // $result = DBHelper::getOne ( $sql );
        $result=DB::select($sql);
        return $result;
    }

    public function saveExportConfigValue($export_protocol,$export_format,$export_url,$export_username,$export_password) {
        $sql="select * from cmt_auto_export  where  export_id = 1  and  export_protocol = $export_protocol  and  export_format = $export_format  and  export_url = '$export_url' and  export_username = '$export_username' and export_password = '$export_password'";
        if(DB::select($sql)){
            return "ok";
        }
        $sql = "UPDATE " . Consts::CMT_AUTO_EXPORT . " SET export_protocol = $export_protocol, export_format = $export_format, export_url = '$export_url', export_username = '$export_username', export_password = '$export_password' WHERE export_id = 1";
        return DB::update ( $sql );
    }

    public function getCheckedProtocol(){
        $sql = "SELECT export_protocol FROM " . Consts::CMT_AUTO_EXPORT . " WHERE export_id = 1 LIMIT 1";
     //  $result = DBHelper::getOne ( $sql );
        $result =  $result=DB::select($sql);
        return $result;
    }

    public function getCheckedFormat(){
        $sql = "SELECT export_format FROM " . Consts::CMT_AUTO_EXPORT . " WHERE export_id = 1 LIMIT 1";
       // $result = DBHelper::getOne ( $sql );
        $result=DB::select($sql);
        return $result;
    }
}
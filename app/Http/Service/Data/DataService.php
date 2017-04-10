<?php
namespace App\Http\Service\Data;
use App\Http\Service\Base\BaseService;
use App\Http\Service\Consts;
use App\Http\Service\Tcp\ThirdCommandHelper;
use Illuminate\Support\Facades\DB;


class DataService extends BaseService
{

    public function commonServiceExportData($params){
        $way = $params ["way"];
        $start_time = $params ["start_time"];
        $end_time = $params ["end_time"];
        $ThirdCommand = new ThirdCommandHelper();
        $res = $ThirdCommand->sendSocket ( Consts::THIRD_CMD_TYPE10, Consts::RESPONSE, Consts::THIRD_DATA_EXPORT, $way."@".$start_time."@".$end_time);
        switch ($res ["result"]) {
            case Consts::CODE_THIRD_ZERO :
                $res ['msg'] = trans("数据成功导出到") . $this->_getExportWayText ($way) . trans("!");
                break;
            case Consts::CODE_THIRD_ONE :
                $res ['msg'] = trans("程序正在执行导出任务 ！");
                break;
            case Consts::CODE_THIRD_TWO :
                $res ['msg'] = trans("未正确获取到飞机尾号 ！");
                break;
            case Consts::CODE_THIRD_THREE :
                $res ['msg'] = trans("日志打包脚本执行错误 ！");
                break;
            case Consts::CODE_THIRD_FOUR :
                $res ['msg'] = trans("未输入日志导出起点时间！");
                break;
            case Consts::CODE_THIRD_FIVE :
                $res ['msg'] = trans("未输入日志导出终点时间！");
                break;
            case Consts::CODE_THIRD_SIX :
                $res ['msg'] = trans("日志导出的目录不存在！");
                break;
            case Consts::CODE_THIRD_SEVEN :
                $res ['msg'] = trans("日志导出的路径不存在！");
                break;
            case Consts::CODE_THIRD_EIGHT :
                $res ['msg'] = trans("没有日志数据可导出！");
                break;
            case Consts::CODE_THIRD_NINE :
                $res ['msg'] = trans("日志打包执行失败！");
                break;
            case Consts::CODE_THIRD_TEN :
                $res ['msg'] = trans("访问数据库失败！");
                break;
            case Consts::CODE_THIRD_ELEVEN :
                $res ['msg'] = trans("执行邮件发送失败！");
                break;
            case Consts::CODE_THIRD_TWELVE :
                $res ['msg'] = trans("执行邮件发送结果无效！");
                break;
            case Consts::CODE_THIRD_THIRTEEN :
                $res ['msg'] = trans("邮件发送的参数无效！");
                break;
            case Consts::CODE_THIRD_FOURTEEN :
                $res ['msg'] = trans("获取邮件相关配置失败！");
                break;
            case Consts::CODE_THIRD_FIFTEEN :
                $res ['msg'] = trans("邮件发送失败！");
                break;
            case Consts::CODE_THIRD_SIXTEEN :
                $res ['msg'] = trans("发送日志到") . $this->_getExportWayText ($way) . trans("失败!");
                break;
            default :
                $res ['msg'] = trans("");
                break;
        }
        if ($res ["result"] == Consts::CODE_THIRD_ZERO || $res ["result"] == Consts::CODE_THIRD_ONE )
        {
            $res ["code"] = Consts::CODE_SUCCESS;
            $this->logOperation($this->_getExportWayText ($way)  .  " export data success!");
        } else{
            $res ["code"] = Consts::CODE_FAILURE;
            $this->logOperation($this->_getExportWayText ($way)  .  " export data failure!");
        }
        return $res;
    }
    private function _getExportWayText($way) {
        switch ($way) {
            case Consts::TRANS_WAY_USB :
                $text = "USB";
                break;

            case Consts::TRANS_WAY_3G :
                $text = "3G E-mail";
                break;

            case Consts::TRANS_WAY_PDL :
                $text = "PDL设备";
                break;

            case Consts::TRANS_WAY_COMSERVER :
                $text = "Common server";
                break;

            default :
                $text = "";
                break;
        }
        return $text;
    }

    public function commonServiceExportDataProgress($params){
        $way = $params ["way"];
        $content_type = $params ["content_type"];
        $format_type = $params ["format_type"];
        $ThirdCommand = new ThirdCommandHelper();
        $res = $ThirdCommand->sendSocket ( Consts::THIRD_CMD_TYPE11, Consts::RESPONSE, Consts::THIRD_DATA_EXPORT, $way."@".$content_type."@".$format_type );
        if ($res ["result"] == Consts::CODE_THIRD_ZERO)
        {
            $res ["result"] = Consts::CODE_SUCCESS;
        } else{
            $res ["result"] = Consts::CODE_FAILURE;
        }
        return $res;
    }



    public function queryProgress() {
        $instance_list = $_SESSION ["instance_list"];
        $trans_way = $_SESSION ["trans_way"];
        $is_sended = true;
        $recver_email = array ();
        foreach ( $instance_list as $value ) {
            $task_instance = $this->taskDAO->getTaskInstance ( $value ["ID"] );
            $is_sended &= $task_instance ["Status"] == TASK_STATUS_SEND_SUCC;
            if (getFilterGroup () == "wifi_hna") {
                $task_type = $value ["TaskDesc"];
                $content_type = strtoupper ( sprintf ( "CT_%s", $task_type ) );
                $recver_email [] = sprintf ( "%s ==> %s" . PHP_EOL, $this->_getContentTypeValue ( constant ( $content_type ), "label" ), $value ["RecvID"] );
            } else if (getFilterGroup () == "wifi_ca" || getFilterGroup () == "wifi_la" || getFilterGroup () == "wifi_yzr") {
                $recver_email [] = $value ["RecvID"];
            }
        }
        $result ["code"] = $is_sended ? CODE_SUCCESS : CODE_FAILURE;

        if (getFilterGroup () == "wifi_hna") {
            if ($trans_way == TRANS_WAY_USB) {
                $result ["msg"] = $is_sended ? Trans::t ( "通过USB导出文件成功，请查看文件：" ) . $_SESSION ["zip_file"] : Trans::t ( "通过USB导出文件失败" );
            } else if ($trans_way == TRANS_WAY_3G) {
                $result ["msg"] = $is_sended ? Trans::t ( "通过3G导出文件成功，请查看邮箱：" ) . "<br/>" . implode ( '<br/>', $recver_email ) : Trans::t ( "通过3G导出文件失败，具体详情查看操作日志" );
            }
        } else if (getFilterGroup () == "wifi_ca" || getFilterGroup () == "wifi_la" || getFilterGroup () == "wifi_yzr") {
            if ($trans_way == TRANS_WAY_USB) {
                $result ["msg"] = $is_sended ? Trans::t ( "通过USB导出文件成功，请查看文件：" ) . $_SESSION ["zip_file"] : Trans::t ( "通过USB导出文件失败" );
            } else if ($trans_way == TRANS_WAY_3G) {
                $result ["msg"] = $is_sended ? Trans::t ( "通过3G导出文件成功，请查看邮箱：" ) . "<br/>" . implode ( '<br/>', $recver_email ) : Trans::t ( "通过3G导出文件失败，具体详情查看操作日志" );
            }
        }
        return $result;
    }

    public function saveAutoExportTactics($exportTactics,$exportInputChecked) {
        $sql = "UPDATE " . Consts::CMT_AUTO_EXPORT . " SET auto_export = $exportTactics,export_type = $exportInputChecked WHERE export_id = 1";
        return DB::update($sql);
    }

    public function saveAutoExportDays($exportDays,$exportInputChecked) {
        $sql = "UPDATE " . Consts::CMT_AUTO_EXPORT . " SET export_days = $exportDays,export_type = $exportInputChecked WHERE export_id = 1";
        return DB::update($sql);
    }

    public function saveAutoExportWeeks($exportWeeks,$exportInputChecked) {
        $sql = "UPDATE " . Consts::CMT_AUTO_EXPORT . " SET export_weeks = $exportWeeks,export_type = $exportInputChecked WHERE export_id = 1";
        return DB::update($sql);
    }

    public function saveAutoExportMonths($exportMonths,$exportInputChecked) {
        $sql = "UPDATE " . Consts::CMT_AUTO_EXPORT . " SET export_months = $exportMonths,export_type = $exportInputChecked WHERE export_id = 1";
        return DB::update($sql);
    }
    public function getAutoExportConfigValue() {
        $sql = "SELECT export_days,export_weeks,export_months,export_type FROM " . Consts::CMT_AUTO_EXPORT . " WHERE export_id = 1 LIMIT 1";
        $result = DB::select($sql);
        return $result;
    }
}
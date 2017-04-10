<?php
namespace App\Http\Service;

use App\Http\Service\Data\DataService;
use App\Http\Service\System\ExtDeviceService;
use App\Http\Service\System\SystemService;
use App\Http\Service\Tcp\CommandHelper;
use App\Http\Service\Update\DeviceUpdateService;
use App\Http\Service\Update\PackageUpdateService;
use App\Http\Service\Update\PdlUpdateService;
use App\Http\Service\Update\ProgramUpdateService;
use App\Http\Service\Update\SystemBackupService;
use App\Http\Service\Update\SystemUpdateService;
use App\Config;
class Maintain
{
    /**检测更新方式
     * @param $way
     */
    public static function checkTransWay($way)
    {
        switch ($way) {
            case Consts::TRANS_WAY_USB:
                $check_result = CommandHelper::sendCommand(Consts::CMD_USB_CHECK, Consts::TARGET_SERVER);
                $result ["code"] = $check_result ["code"] == Consts::CODE_EXEC_SUCCESS ? Consts::CODE_SUCCESS : Consts::CODE_FAILURE;
                break;
            case Consts::TRANS_WAY_FTP :
                $check_result = CommandHelper::sendCommand(Consts::CMD_FTP_CHECK, Consts::TARGET_SERVER);
                $result ["code"] = $check_result ["code"] == Consts::CODE_EXEC_SUCCESS ? Consts::CODE_SUCCESS : Consts::CODE_FAILURE;
                break;
            case Consts::TRANS_WAY_3G :
              //  $check_result = CommandHelper::sendCommand(Consts::CMD_3G_CONTROAL, Consts::TARGET_3G_QUERY);
                //$result ["code"] = $check_result ["code"] == Consts::CODE_3G_OPEN ? Consts::CODE_SUCCESS : Consts::CODE_FAILURE;
                $config = new Config;

                $status= $config->getPublicStatus("4G");
                if($status==1){
                    $result ["code"]=Consts::CODE_SUCCESS;
                }else{
                    $result ["code"]=Consts::CODE_FAILURE;
                }
                break;
            case Consts::TRANS_WAY_PDL :
                $check_result = CommandHelper::sendCommand(Consts::CMD_DEVICE_STATUS, Consts::TARGET_PDL, "ALL");
                $result ["code"] = ($check_result ["code"] == Consts::CODE_EXEC_SUCCESS && $check_result ["content"] ["status"] == "00") ? Consts::CODE_SUCCESS : Consts::CODE_FAILURE;
                break;
            case Consts::TRANS_WAY_COMSERVER :
                $result ["code"] = Consts::CODE_SUCCESS;
                break;
            default :
                $result ["code"] = Consts::CODE_FAILURE;
                break;
        }
        if ($result ["code"] == Consts::CODE_FAILURE) {
            switch ($way) {
                case Consts::TRANS_WAY_USB :
                    $result ["msg"] = trans("maintain.usb");
                    //$this->logOperation("usb export data failure!");
                    break;

                case Consts::TRANS_WAY_3G :
                    $result ["msg"] = trans("maintain.3g");
                    //$this->logOperation("3g export data failure!");
                    break;

                case Consts::TRANS_WAY_FTP :
                    $result ["msg"] = trans("maintain.ftp");
                    // $this->logOperation("ftp export data failure!");
                    break;
                default :
                    $result ["msg"] = trans("maintain.unkonwerror");
                    // $this->logOperation("export data unknown error!");
                    break;
            }
        }
        return $result;
    }

    /**
     * 查询系统是否有更新
     */
    public static function querySysUpdate()
    {
        $service = new SystemUpdateService();
        $result = $service->checkVersion();
        return $result;
    }

    /**
     * 查询版本
     */
    public static function queryVersion()
    {
        $service = new SystemUpdateService();
        $result = $service->queryVersion();
        return $result;
    }

    /**
     * 拷包
     */
    public static function copyPackage()
    {
        $service = new PackageUpdateService();
        $result = $service->start(Consts::TARGET_SERVER);
        return $result;
    }

    /**
     * 查询拷包进度
     */
    public static function queryCopyProgress()
    {
        $service = new PackageUpdateService();
        $result = $service->queryProgress(Consts::TARGET_SERVER);
        return $result;
    }

    /**
     * 查询部件是否有更新
     */
    public static function queryDevUpdate()
    {
        $service = new DeviceUpdateService();
        $result = $service->checkVersion();
        return $result;
    }

    /**
     * 系统备份
     */
    public static function sysBackup()
    {
        $service = new SystemBackupService();
        $result = $service->start(Consts::TARGET_SERVER);
        return $result;
    }

    /**
     * 查询系统备份进度
     */
    public static function queryBackupProgress()
    {
        $service = new SystemBackupService();
        $result = $service->queryProgress(Consts::TARGET_SERVER);
        return $result;
    }

    /**
     * 查询节目版本
     */
    public static function queryProgVersion()
    {
        $service = new ProgramUpdateService();
        $result = $service->queryVersion();
        return $result;
    }

    /**
     * 查询节目更新
     */
    public static function queryProgUpdate($way)
    {

        if ($way == Consts::TRANS_WAY_USB) {
            $service = new ProgramUpdateService();
        } else {
            $service = new PdlUpdateService();
        }
        $result = $service->checkVersion();
        return $result;
    }

    /**
     * 开始节目更新
     */
    public static function startProgUpdate($way)
    {

        if ($way === Consts::TRANS_WAY_USB) {
            $service = new ProgramUpdateService();
        } else {
            $service = new PdlUpdateService();
        }
        $result = $service->start(Consts::TARGET_SERVER);
        return $result;
    }

    /**
     * 查询节目更新进度
     */
    public static function queryProgUpdateProgress($way)
    {
        if ($way === Consts::TRANS_WAY_USB) {
            $service = new PackageUpdateService();
        } else {
            $service = new PdlUpdateService();
        }
        $result = $service->queryProgress(Consts::TARGET_SERVER);
        return $result;
    }

    public static function querySysUpdateProgress($target)
    {
        $target = empty ($target) ? Consts::TARGET_ALL : $target;
        $service_type = empty ($target) ? Consts::UPDATE_TYPE_SYS : Consts::UPDATE_TYPE_DEV;
        if ($service_type == Consts::UPDATE_TYPE_SYS) {
            $service = new SystemUpdateService();
        } else {
            $service = new DeviceUpdateService();
        }
        $result = $service->queryProgress($target);
        return $result;
    }

    public static function startUpdate($target)
    {
        $target = empty ($target) ? Consts::TARGET_ALL : $target;
        $service_type = empty ($target) ? Consts::UPDATE_TYPE_SYS : Consts::UPDATE_TYPE_DEV;
        if ($service_type == Consts::UPDATE_TYPE_SYS) {
            $service = new SystemUpdateService();
        } else {
            $service = new DeviceUpdateService();
        }
        $result = $service->start($target);
        return $result;
    }

    /**
     * 导出数据
     */
    public static function exportData($params)
    {
        $service = new DataService();
        $result = $service->commonServiceExportData($params);
        return $result;
    }

    /**
     * 查询导出数据的进度
     */
    public static function queryExportDataProgress($way, $content_type, $format_type, $start_time, $end_time)
    {
        $params = array(
            "way" => $way,
            "content_type" => $content_type,
            "format_type" => $format_type,
            "start_time" => $start_time,
            "end_time" => $end_time
        );
        $service = new DataService();
        if ($way == 20) {
            $result = $service->commonServiceExportDataProgress($params);
        } else {
            $result = $service->queryProgress();
        }
        return $result;
    }

    /**保存自动导出
     * @param $exportTactics
     * @param $exportDays
     * @param $exportWeeks
     * @param $exportMonths
     * @param $exportInputChecked
     */
    public static function autoExportConfig($exportTactics, $exportDays, $exportWeeks, $exportMonths, $exportInputChecked)
    {
        $service = new DataService();
        if ($exportInputChecked == 1) {
            $service->saveAutoExportTactics($exportTactics, $exportInputChecked);
        }
        if ($exportInputChecked == 2) {
            $service->saveAutoExportDays($exportDays, $exportInputChecked);
        }
        if ($exportInputChecked == 3) {
            $service->saveAutoExportWeeks($exportWeeks, $exportInputChecked);
        }
        if ($exportInputChecked == 4) {
            $service->saveAutoExportMonths($exportMonths, $exportInputChecked);
        }

    }

    public static function getAutoExportConfigValue()
    {
        $service = new DataService();
        return $service->getAutoExportConfigValue();
    }

    /**
     * 切换wifi模式
     */
    public static function switchWifiMode($mode,$responsable = true)
    {
        $service = new SystemService();
        $result = $service->switchWifiMode($mode,$responsable);
        return $result;
    }
    public static function switchWifi($mode){
        $service = new SystemService();
        $result = $service->switchWifi($mode);
        return $result;
    }
    public static function wifiSwitch($mode){
        $service = new SystemService();
        $result = $service->wifiSwitch($mode);
        return $result;
    }
    public static function switch4GMode($mode){
        $service = new SystemService();
        $result = $service->switch4GMode($mode);
        return $result;
    }
    /**
     * 查询wifi
     */
    public static function queryWifi()
    {
        $service = new SystemService();
        $result = $service->queryWifi();
        return $result;
    }

    /**查询wifi Mode
     * @return array
     */
    public static function queryWifiMode()
    {
        $service = new SystemService();
        $result = $service->queryWifiMode();
        return $result;
    }

    /**将制定的ap打开或者关闭
     * @param $mode
     * @param $positionID
     * @return array
     */
    public static function switchAP($mode, $positionID)
    {
        $service = new SystemService();
        $result = $service->switchAP($positionID, $mode);
        return $result;
    }

    /**
     * 自检
     */
    public static function startBite($dev_id)
    {
        $service = new ExtDeviceService();
        $result = $service->bite($dev_id);
        return $result;
    }
    /**
     * 恢复出厂设置
     */
    public static function resetFactory()
    {
        $service = new SystemService();
        $result = $service->resetFactory();
        return $result;
    }

    public static function logSwitchAP($positionID, $mode, $code)
    {
        $service = new SystemService();
        $result=$service->logSwitchAP($positionID, $mode, $code);
        return $result;
    }

    public static function logSwitchATG($mode, $code){
        $service = new SystemService();
        $result=$service->logSwitchATG($mode,$code);
        return $result;
    }
    /**
     * 节目升级完后删除文件
     */
    public static function cleanup()
    {
        $service = new ProgramUpdateService();
        $result = $service->cleanup();
        return $result;
    }


}
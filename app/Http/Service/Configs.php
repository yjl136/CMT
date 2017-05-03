<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/8
 * Time: 17:32
 */

namespace App\Http\Service;

use App\Http\Service\Config\ConfigService;
use App\Http\Service\Config\DiagnoseService;
use App\Http\Service\Tcp\CommandHelper;

class Configs
{
    /**时间同步
     * @param $params
     * @return mixed
     */
    public static function timesync($params)
    {
        $service = new ConfigService();
        $result = $service->syncTime($params);
        return $result;
    }

    /**
     * 重启
     */
    public static function reboot($target)
    {
        $service = new ConfigService();
        $result = $service->reboot($target);
        return $result;
    }

    public static function transmissionconfig()
    {
        $service = new ConfigService();
        $transportProtocol = $service->getTransportProtocol();
        $exportMethod = $service->getExportMethod();
        $exportList = $service->getExportList();
        return compact('transportProtocol','exportMethod','exportList');
    }
    public static function transConfigSave($export_protocol, $export_username,$export_password,$export_format,$export_url){
        $service = new ConfigService();
        $result=  $service->saveExportConfigValue($export_protocol,$export_format,$export_url,$export_username,$export_password);
        return $result;
    }
    /**
     * 屏幕校准
     */
    public static function calibration()
    {
        return CommandHelper::sendCommand(Consts::CMD_SCRN_CALIBRATE, Consts::TARGET_CMT, "", false);
    }
    /**
     * 自检
     */
   public static function diagnose(){
       //设置状态
       $service=new DiagnoseService();
       $service->diagnose();
   }

    /**
     * 从xml中获取设置的语言
     */
    public static function getLang(){
        if (file_exists ('config.xml')) {
            $xml=simplexml_load_file('config.xml');
            $langs= $xml->xpath('lang');
            $lang = array_shift ($langs);
            if(empty($lang)){
                $lang='zh_CN';
            }
        }else{
            $lang='zh_CN';
        }
        return $lang;
    }

}
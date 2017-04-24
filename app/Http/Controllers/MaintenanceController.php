<?php

namespace App\Http\Controllers;

use App\Http\Service\Log\SessionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Support\Helpers\Formatter;
use App\Syslog;
use App\Device;
use App\System;
use App\Config;
use Carbon\Carbon;
use App\Http\Service\Configs;
use App\Http\Service\Consts;
use App\Http\Service\Maintain;
use App\Http\Service\Utils\ConvertHelper;
use App\Http\Service\Utils\UpdateWays;
use Symfony\Component\HttpKernel\EventListener\SessionListener;


class MaintenanceController extends Controller
{
    public function topo()
    {
        $device = new Device();
        $deviceInfos = $device->getDeviceList();
        return view('userMaintenance.topo',compact('deviceInfos'));
    }

    public function flight()
    {
        $currentTime = Carbon::now()->timezone('Asia/Shanghai');
        $config = new Config;
        $device = new Device;
        $format = new Formatter();
        $deviceInfos = $device->getDeviceList();
        $flight_parameter = array_flatten($config->getSomeFlightData());
        $data = array($flight_parameter[0]->Name => $format::formatAltitude($flight_parameter[0]->Value),
            $flight_parameter[1]->Name => $format::formatSpeed($flight_parameter[1]->Value),
            $flight_parameter[2]->Name => $format::formatLatitude($flight_parameter[2]->Value),
            $flight_parameter[3]->Name => $format::formatLongitude($flight_parameter[3]->Value)
        );
        return view('userMaintenance.flight',compact('currentTime','deviceInfos','data'));
    }

    public function deviceList() {
        $device = new Device();
        $deviceInfos = $device->getDeviceList();
        return view('userMaintenance.list',compact('deviceInfos'));
    }

    public function deviceDetail($mac)
    {
        $device = new Device();
        $deviceDetail = $device->getDeviceDetailByMac($mac);
        if ($deviceDetail->Name == 'Server'){
            $devicePhysicInfo = $device->getDevicePhysicInfoByMac($mac);
            $hardDiskInfo = $device->getDeviceHardDiskInfoByMac($mac);
            $data = $device->getApplicationRunInfoByMac($mac);
            $appData = $device->formatApplicationRunInfo($data);
            $g4_data = $device->getFourGCardData();
        } elseif ($deviceDetail->Name == 'CAP'){
            $capPosition = $deviceDetail->DevPosition;
            $data = $device->getCapStatusInfoByMac($capPosition,$mac);
            $capStatusInfo = $device->formatCapStatusInfo($data,$capPosition);
        }
        return view('userMaintenance.detail',compact('deviceDetail','devicePhysicInfo','hardDiskInfo','appData','capStatusInfo','capPosition','g4_data'));
    }

    /**
     * @param $mac
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 分页取出设备警告信息,以及根据mac地址查出设备名称
     */
    public function deviceAlarmInfo($mac, $alarm_level='', $clear_status='', $start_time='', $end_time='')
    {
        $device = new Device();
        $deviceDetail = $device->getDeviceDetailByMac($mac);
        $device = new Syslog();
        $deviceAlarmData = $device->getDeviceAlarmLogPaginateData($mac, $alarm_level, $clear_status, $start_time, $end_time);
        return view('userMaintenance.alarmInfo',compact('deviceDetail','deviceAlarmData'));
    }

    public function bite() {
        $system = new System;
        $biteParam = $system->getDeviceList();
        return view('userMaintenance.bite',compact('biteParam'));
    }

    public function biteResult($mac) {
        $device = new Device();
        $deviceDetail = $device->getDeviceDetailByMac($mac);
        if ($deviceDetail->Name == 'Server'){
            $devicePhysicInfo = $device->getDevicePhysicInfoByMac($mac);
            $hardDiskInfo = $device->getDeviceHardDiskInfoByMac($mac);
            $data = $device->getApplicationRunInfoByMac($mac);
            $appData = $device->formatApplicationRunInfo($data);
            $g4_data = $device->getFourGCardData();
        } elseif ($deviceDetail->Name == 'CAP'){
            $capPosition = $deviceDetail->DevPosition;
            $data = $device->getCapStatusInfoByMac($capPosition,$mac);
            $capStatusInfo = $device->formatCapStatusInfo($data,$capPosition);
        }
        return view('userMaintenance.biteResult',compact('deviceDetail','devicePhysicInfo','hardDiskInfo','appData','capStatusInfo','capPosition','g4_data'));
    }

    public function sysUpgrade() {
        return view('userMaintenance.sysUpgrade');
    }

    public function devUpgrade() {
        return view('userMaintenance.devUpgrade');
    }

    public function sysBackup($do=null) {
        if ($do == "backup") {
            $result = Maintain::sysBackup();
            // $this->saveOperation ( "backup [" . $_SESSION ['cmt_user_type'] . "] start " );
            echo json_encode ( $result );
        } else if ($do == "query") {
            $result = Maintain::queryBackupProgress();
            echo json_encode ( $result );
        }else{
            return view('userMaintenance.sysBackup');
        }
    }


    public function progUpdate() {
        return view('userMaintenance.progUpdate');
    }

    public function dataExport() {
        $transWays=UpdateWays::getTransWays();
        $formatTypes=UpdateWays::getFormatTypes();
        return view('userMaintenance.dataExport',compact('transWays','formatTypes'));
    }

    public function autoExport() {
        $result = Maintain::getAutoExportConfigValue ();
        $list = ConvertHelper::object2array($result[0]);
        return view('userMaintenance.autoExport',compact('list'));
    }

    public function sysTest() {
        return view('userMaintenance.sysTest');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * operate log
     */
    public function operateLog($content='',$start_time='',$end_time=''){
        $syslog = new Syslog;
        $operateList = $syslog->getOperatePaginateData($content,$start_time,$end_time);
        return view('userMaintenance.operateLog',compact('operateList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * dial log
     */
    public function dialLog(){
        $syslog = new Syslog;
        $dialList = $syslog->getDialPaginateData();
      /*  $log_time	= $dialList[0]->create_time;
        $lists		= explode('@', $dialList[0]->message);*/
        return view('userMaintenance.dialLog',compact('dialList'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * alarm log
     */
    public function alarmLog($dev_type='', $alarm_level='', $clear_status='', $start_time='', $end_time=''){
        $syslog = new Syslog;
        $alarmLogList = $syslog->getAlarmLogPaginateData($dev_type, $alarm_level, $clear_status, $start_time, $end_time);
        return view('userMaintenance.alarmLog',compact('alarmLogList'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * running log
     */
    public function runningLog($dev_type='',$start_time='',$end_time=''){
        $syslog = new Syslog;
        $runningList = $syslog->getRunningPaginateData($dev_type,$start_time,$end_time);
        return view('userMaintenance.runningLog',compact('runningList'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * flight log
     */
    public function flightLog(){
        $syslog = new Syslog;
        $flightList = $syslog->getFlightPaginateData();
        return view('userMaintenance.flightLog',compact('flightList'));
    }

    public function version() {
        $system = new System;
        $versionInfo = $system->getVersionInfo();
        return view('userMaintenance.version',compact('versionInfo'));
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            SessionLog::log(">>uri: ".$request->path()."   <<cookie:  ".print_r ( $request->cookie(), true ));
            if (empty($request->session()->get('cmt_user_name')) || empty($request->session()->get('cmt_user_type'))) {
                return redirect('/');
            }else{
                return $next($request);
            }
        });
    }


}

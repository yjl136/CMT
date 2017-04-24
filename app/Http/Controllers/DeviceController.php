<?php

namespace App\Http\Controllers;
use App\Config;
use App\Http\Service\Log\SessionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Support\Helpers\Formatter;
use App\Syslog;
use App\Device;

class DeviceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * topo页面，展示设备的直观在线状态
     */
    public function topo() {
        $device = new Device();
        $deviceInfos = $device->getDeviceList();
        return view('device.topo',compact('deviceInfos'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 设备列表页面
     */
    public function deviceList() {
        $device = new Device();
        $deviceInfos = $device->getDeviceList();
        return view('device.list',compact('deviceInfos'));
    }

    /**
     * @param $mac
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 设备详情页面
     */
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
        return view('device.detail',compact('deviceDetail','devicePhysicInfo','hardDiskInfo','appData','capStatusInfo','capPosition','g4_data'));
    }

    public function showDisplaceStatus() {
        $config=new Config();
        $result = $config->getCapReplaceValue();
        return response()->json($result->var_value);
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
        return view('device.alarmInfo',compact('deviceDetail','deviceAlarmData'));
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

          //  SessionLog::log("device>> cmt_user_name: ".$request->session()->get('cmt_user_name')."   cmt_user_type:".$request->session()->get('cmt_user_type'));
            if (empty($request->session()->get('cmt_user_name')) || empty($request->session()->get('cmt_user_type'))) {
                return redirect('/');
            }else{
                return $next($request);
            }
        });
    }

}

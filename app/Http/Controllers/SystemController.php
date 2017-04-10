<?php

namespace App\Http\Controllers;

use App\Http\Service\Maintain;
use Illuminate\Http\Request;
use App\System;
use App\Device;

class SystemController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 渲染自检页面，获取设备列表信息
     */
    public function bite() {
        $system = new System;
        $biteParam = $system->getDeviceList();
        return view('system.bite',compact('biteParam'));
    }

    public function showStartBite($dev_id) {
        $result = Maintain::startBite($dev_id);
        echo json_encode ( $result );
    }

    public function showQueryBite() {
        $dev_type = $_GET ["dev_type"];
        $bite_time = $_GET ["bite_time"];

        include_once 'Lib/Service/DeviceService.php';
        $service = new DeviceService ();

        // 查询自检
        $result = $service->bite ( $dev_type );
        echo json_encode ( $result );
        $this->exitSystem ();
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
        return view('system.biteResult',compact('deviceDetail','devicePhysicInfo','hardDiskInfo','appData','capStatusInfo','capPosition','g4_data'));
    }

    public function sysTest() {
//        $this->changeMenuKey ();
//        $this->setSubMenu ( "systemTest" );
//
//        include_once 'Lib/Service/AccessPointService.php';
//        $Service = new AccessPointService ();
//
//        // 获取AP列表
//        $ap_list = $Service->getAPList ();
//
//        $this->Tmpl ["ap_list"] = $ap_list;
//        $this->Tmpl ["cmt_user_type"] = $_SESSION ["cmt_user_type"];
//        $this->display ();
        return view('system.sysTest');
    }

    public function showAtgTest() {
        $do = $_GET ["do"];

        $this->changeMenuKey ();
        $this->setSubMenu ( "systemTest" );

        include_once 'Lib/Service/ExtDeviceService.php';
        $service = new ExtDeviceService ();

        $cpe = $service->getDeviceListByDevType ( TARGET_CPE, true );
        if ($do == "query") {
            echo json_encode ( $cpe );
            $this->exitSystem ();
        }

        $this->Tmpl ["cpe"] = $cpe;
        $this->display ();
    }

    public function showResetFactory() {
        $result = Maintain::resetFactory();
        echo json_encode ( $result );
    }

    public function showQueryWifiMode() {
        $result = Maintain::queryWifiMode();
        echo json_encode ( $result );

    }



    public function showQueryWifi() {
        $list =Maintain::queryWifi();
        echo json_encode ( $list );

    }

    public function showSwitchWifi($mode) {
       $result=Maintain::switchWifi($mode);
        echo json_encode ( $result );
    }
    public function showSwitchWifiMode($mode) {
       $result=Maintain::switchWifiMode($mode);
        echo json_encode ( $result );
    }

    /**
     * @param $mode4G切换
     */
    public function showSwitch4G($mode) {
        $result=Maintain::switch4GMode($mode);
        echo json_encode ( $result );
    }

    public function showSwitchAP($mode,$positionID) {
        $result = Maintain::switchAP($mode,$positionID);
        echo json_encode ( $result );
    }

    public function showSwitchATG(Request $request) {
        $mode = $request->input("mode");
        $result = $this->service->switchAP ( 7, $mode );
        echo json_encode ( $result );
    }

    public function showLogOperation(Request $request) {
        $positionID = $request->input("positionID");
        $mode = $request->input("mode");
        $code = $request->input("code");
        $type = $request->input("type");
        if (empty ( $type )) {
            // 记录AP操作日志
            $result = Maintain::logSwitchAP($positionID,$mode,$code);
        } else if ($type == "ATG") {
            // 记录ATG操作日志
            $result = Maintain::logSwitchATG($mode,$code);
        }
        echo json_encode ( $result );
    }

    public function showPlane() {
        $service = new SystemService ();
        $plane = $service->getPlane ();
        $this->Tmpl ['plane'] = $plane;
        $this->setLeftMenu ( 'system' );
        $this->display ();
    }

    public function version() {
        $system = new System;
        $versionInfo = $system->getVersionInfo();
        return view('system.version',compact('versionInfo'));
    }

    public function showDevReboot() {
        $do = $_GET ["do"];
        if (empty ( $do )) {
            include_once 'Lib/Service/ExtDeviceService.php';
            $service = new ExtDeviceService ();
            $list = $service->getAllDevice ();
            $this->Tmpl ["list"] = $list;
            $this->display ();
        } else {
            include_once 'Lib/Service/UpdateService.php';
            $service = new UpdateService ();
            $result = $service->reboot ( $_GET ["dev_type"], $_GET ["dev_position"] );
            echo json_encode ( $result );
            $this->exitSystem ();
        }
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (empty($request->session()->get('cmt_user_name')) || empty($request->session()->get('cmt_user_type'))) {
                return redirect('/');
            }else{
                return $next($request);
            }
        });
    }
}

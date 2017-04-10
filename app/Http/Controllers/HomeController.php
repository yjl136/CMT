<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Service\Maintain;
use Illuminate\Http\Request;
use App\Config;
use Carbon\Carbon;
use App\Support\Helpers\Formatter;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登录以及一些参数监视页面
     */
    public function home(Request $request)
    {
        $timeType = env('TYPE_TIME');   //根据配置文件获取时间类型
        $config = new Config;
        $diagnose_status = $config->getDiagnoseStatus();   //得到系统的诊断状态
        $diagnose_message = $config->getDiagnoseMessage($diagnose_status); //得到WIFI的错误信息
        $message_list = $config->getTroubleMessageList($diagnose_status); //得到所有的错误提示信息
        $status = $config->getStatus();        //得到一些状态值以及参数值
        $ftp_version = $config->getFtpVersion();  //得到ftp的最新版本
        $ftp_version_flag = $config->getFtpVersionFlag();  //得到ftp是否显示新版本的标识
        return view('home.login',compact('timeType','diagnose_message','message_list','status','ftp_version','ftp_version_flag'));
    }

    public function newVersionInfo(){
        $config = new Config;
        $version['status'] = $config->getStatus();        //得到一些状态值以及参数值
        $version['version'] = $config->getFtpVersion();  //得到ftp的最新版本
        $version['flag'] = $config->getFtpVersionFlag();  //得到ftp是否显示新版本的标识
        return $version;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 飞行参数页面，包括经度，纬度，高度，速度
     */
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
        return view('home.flight',compact('currentTime','deviceInfos','data'));
    }

    /**
     * @return array
     * 得到监视页面所有的状态值以及参数值
     */
    public function status(Request $request)
    {
        $config = new Config;
        $status = $config->getStatus();
        return $status;
    }
    public function showSwitchWifi($mode) {
        $result=Maintain::wifiSwitch($mode);
        echo json_encode ( $result );
    }

    /**
     * @param $mode4G切换
     */
    public function showSwitch4G($mode) {
        $result=Maintain::switch4GMode($mode);
        echo json_encode ( $result );
    }
    /**
     * @return array
     * 一键自检
     * 首先获取监视状态，然后获取所有的错误信息，再将所有的错误信息记录到数据表中
     */
    public function onekeyBite()
    {
        $config = new Config;
        $diagnose_status = $config->getDiagnoseStatus();
        $message_list = $config->getTroubleMessageList();
        foreach ($message_list as $message){
            $err_type = $message->Type;
            $err_code = $message->TroubleCode;
            $err_msg = $message->Description;
            if ($err_code > 0 && $err_code < 5) {
                $config->getTroubleMessageTo($err_type, $err_code, $err_msg);
            }
        }
        $result["diagnose_status"] = $diagnose_status;
        $result["diagnose_message"] = $config->getDiagnoseMessage($diagnose_status);
        $result["message_list"] = $message_list;
        return $result;
    }

//    public function __construct()
//    {
//        $this->middleware(function ($request, $next) {
//            if (empty($request->session()->get('cmt_user_name')) || empty($request->session()->get('cmt_user_type'))) {
//                return redirect('/');
//            }else{
//                return $next($request);
//            }
//        });
//    }


}

<?php

namespace App\Http\Controllers;

use App\Http\Service\Configs;
use App\Http\Service\Maintain;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Config;
use Carbon\Carbon;


define ( "DEV_CMT_SITE", '0-a' ); // CMT site
define ( "DEV_SERVER_SITE", '0-b' ); // SERVER site
define ( "DEV_CAP_SITE1", '0-ap-1' ); // CAP1 site
define ( "DEV_CAP_SITE2", '0-ap-2' ); // CAP2 site
define ( "DEV_CAP_SITE3", '0-ap-3' ); // CAP3 site
define ( "DEVSEQ", 0 ); // DevSeq
define ( "DEVMODEL", 1 ); // DevModel
define ( "USB_UPDATE_METHOD", 1 ); // usb_update_method
define ( "FTP_UPDATE_METHOD", 4 ); // ftp_update_method
define ( "HTTP_UPDATE_METHOD", 19 ); // http_update_method

class ConfigController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 收信配置
     */
    public function receiver() {
        $config = new Config;
        $receiverList = $config->getReceiverList();
        return view('config.receiver',compact('receiverList'));
    }

    /**
     * @param $mail_type
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 收信人邮箱修改
     */
    public function receiverEdit($mail_type,Request $request){
        $config = new Config;
        if ($request->ajax()){
            $user_id = $request->get('UserID');
            $result = $config->updateReceiver ( $mail_type, $user_id );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $receive = $config->getReceiverByMailType($mail_type);
            return view('config.receiverEdit',compact('receive'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 发信配置
     */
    public function sender() {
        $config = new Config;
        $senderList = $config->getSenderList();
        return view('config.sender',compact('senderList'));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 发件人邮箱参数修改
     */
    public function senderEdit($user_id,Request $request){
        $config = new Config;
        if ($request->ajax()){
            $user_id = $request->get('UserID');
            $pwd = $request->get('Pwd');
            $smtpsvr = $request->get('SmtpSvr');
            $port = $request->get('Port');
            $result = $config->updateSender ( $user_id, $pwd, $smtpsvr, $port );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $sender = $config->getSenderByUserId($user_id);
            return view('config.senderEdit',compact('sender'));
        }
    }

    public function senderValidate(Request $request)
    {
        $config = new Config;
        $user_id = $request->get('UserID');
        $result = $config->validateSender ( $user_id );
        return $result;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 时间同步
     */
    public function timesync(Request $request) {
        if ($request->ajax()){
            $current_time = $request->get('current_time');
            $param = array("mode"=>2,"current_time"=>$current_time);
            $result=Configs::timesync($param);
            return json_encode($result);
        }else{
            $timeType = env('TYPE_TIME');
            $utc_time = Carbon::now();
            $current_time = Carbon::now()->timezone('Asia/Shanghai');
            return view('config.timesync',compact('current_time','utc_time','timeType'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 用户列表展示
     */
    public function user() {
        $config = new Config;
        $userList = $config->getUserList();
        return view('config.user',compact('userList'));
    }

    /**
     * @param $user_type
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 用户密码修改
     */
    public function userEdit($user_type,Request $request) {
        $config = new Config;
        if ($request->ajax()){
            $new_password = $request->get('newpassword');
            $result = $config->updateUser ( $user_type, $new_password );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $user = $config->getUserByUserType($user_type);
            $password = $user->password;
            return view('config.userEdit',compact('user','password'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 系统序列号配置
     */
    public function sysConfig(Request $request) {
        $config = new Config;
        if ($request->ajax()){
            $system_id = $request->get('system_id');
            $result = $config->updateSystemId ($system_id );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $system_id = $config->getSystemIdByName("system_id");
            return view('config.sysconfig',compact('system_id'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 通过USB进行系统升级的一些参数配置
     */
    public function usbconfig(Request $request) {
        $config = new Config;
        if ($request->ajax()){
            $url = $request->get('url');
            $username = $request->get('username');
            $password = $request->get('password');
            $result = $config->updateSystemUpgradeUsbConfig ($type=1, $url, $username, $password );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $data = $config->getUsbConfigInfoByUpgradeMethod();
            return view('config.usbconfig',compact('data'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 数据导出的参数配置
     */
    public function transmission(Request $request) {
        return view('config.transmissionconfig',Configs::transmissionconfig());
    }


    public function transmissionsave(Request $request) {
            $exportUrl = $request->get('exportUrl');
            $exportUserName = $request->get('exportUserName');
            $exportPassword = $request->get('exportPassword');
            $exportMethod = $request->get('exportMethod');
            $transportProtocol = $request->get('transportProtocol');
            $result = Configs::transConfigSave($transportProtocol,$exportUserName,$exportPassword,$exportMethod,$exportUrl);
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
    }

    public function serverConfig(Request $request)
    {
        $config = new Config;
        if ($request->ajax()){
            $server_sn = $request->get('server_sn');
            $server_em = $request->get('server_em');
            $result = $config->updateServerConfig ( $type=4, $server_sn, $server_em );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $data = $config->getServerConfigInfo();
            return view('config.serverconfig',compact('data'));
        }
    }

    public function capConfig(Request $request)
    {
        $config = new Config;
        if ($request->ajax()){
            $cap_sn1 = $request->get('cap_sn1');
            $cap_sn2 = $request->get('cap_sn2');
            $cap_sn3 = $request->get('cap_sn3');
            $cap_em1 = $request->get('cap_em1');
            $cap_em2 = $request->get('cap_em2');
            $cap_em3 = $request->get('cap_em3');
            $result = $config->updateCapSnAndModConfig ( $cap_sn1, $cap_em1, $cap_sn2, $cap_em2, $cap_sn3, $cap_em3 );
            if ($result){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            $data = $config->getCapConfigInfo();
            return view('config.capconfig',compact('data'));
        }
    }
 public function networkModeConfig(Request $request){
     $config = new Config;
     if ($request->ajax()){
         $mode = $request->get('mode');
         $result = $config->updateNetWorkMode($mode);
         if ($result){
             return response()->json("success");
         }else{
             return response()->json("error");
         }
     }else{
         $data = $config->getNetWorkMode();
         return view('config.networkconfig',compact('data'));
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

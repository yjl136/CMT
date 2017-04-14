<?php

namespace App\Http\Controllers;

use App\Http\Service\Configs;
use Illuminate\Http\Request;
use App\Dashboard;
use Carbon\Carbon;
use App\Config;


// 状态信号，包括429信号
define ( "DASHBOARD_ALTITUDE", 1 ); // Altitude
define ( "DASHBOARD_AIR_SPEED", 2 ); // Air Speed
define ( "DASHBOARD_LATITUDE", 3 ); // Latitude
define ( "DASHBOARD_LONGITUDE", 4 ); // Longitude
define ( "DASHBOARD_UTC_TIME", 5 ); // UTC Time
define ( "DASHBOARD_GROUND_SPEED", 6 ); // Ground Speed
define ( "DASHBOARD_3G", 11 ); // 3G
define ( "DASHBOARD_PA", 12 ); // PA
define ( "DASHBOARD_WOW", 13 ); // WoW
define ( "DASHBOARD_ATG", 14 ); // ATG
define ( "DASHBOARD_ONLINEUSERS", 47 ); // Online Users
define ( "DASHBOARD_WIFI", 48 ); // WiFi
define ( "DASHBOARD_VA", 49 ); // VA
define ( "DASHBOARD_DOOR", 50 ); // Door

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * 提供对外的api接口，用以查询WiFI系统各个监控部位的状态值以及参数值
     */
    public function queryValue(Request $request) {
        $dashboard = new Dashboard();
        $type = $request->input('type');
        $data = $dashboard->getDashboardTableValue ( $type );
        $dashboardData = $data;
        switch ($type) {
            case DASHBOARD_3G :
            case DASHBOARD_PA :
            case DASHBOARD_WOW :
            case DASHBOARD_DOOR :
            case DASHBOARD_ATG :
            case DASHBOARD_WIFI :
            case DASHBOARD_VA :
                $dash_info ["name"] = $dashboardData[0]->Name;
                $dash_info ["value"] = $dashboardData[0]->Value == '1' ? 1 : 0;
                $dash_info ["time"] = Carbon::now()->timezone('Asia/Shanghai');
                break;

            default :
                $dash_info ["name"] = $dashboardData[0]->Name;
                $dash_info ["value"] = $dashboardData[0]->Value;
                $dash_info ["time"] = Carbon::now()->timezone('Asia/Shanghai');
                break;
        }
        return $dash_info;
    }

    /**
     * @return array
     * 得到监视页面所有的状态值以及参数值
     */
    public function status()
    {
        $config = new Config;
        $status = $config->getStatus();
        return $status;
    }

    /**
     * @return array
     * 一键自检
     * 首先获取监视状态，然后获取所有的错误信息，再将所有的错误信息记录到数据表中
     */
    public function onekeyBite()
    {

        Configs::diagnose();
        $config = new Config;
        $diagnose_status = $config->getDiagnoseStatus();
        $message_list = $config->getTroubleMessageList($diagnose_status);
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


}

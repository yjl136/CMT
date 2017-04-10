<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use App\Config;
use Carbon\Carbon;
use App\Support\Helpers\Formatter;

class OperateController extends Controller
{
    public function topo()
    {
        $device = new Device();
        $deviceInfos = $device->getDeviceList();
        return view('userOperate.topo',compact('deviceInfos'));
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
        return view('userOperate.flight',compact('currentTime','deviceInfos','data'));
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

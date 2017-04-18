<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Support\Helpers\Formatter;

class Device extends Model
{
    public function getDeviceList()
    {
        $deviceInfos = DB::table('oam_device')
            ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
            ->where('oam_device.DevType', '!=', '14')
            ->where('oam_device.DevType', '!=', '13')
            ->where('oam_device.DevType', '!=', '5')
            ->select('oam_device.DevID',
                'oam_device.DevType',
                'oam_device.DevStatus',
                'oam_device.IPAddress',
                'oam_device.DevPosition',
                'oam_devicecategory.Name',
                'oam_devicecategory.Descs')
            ->get();
        return $deviceInfos;
    }

    public function getDeviceDetailByMac($mac)
    {
        $deviceDetail = DB::table('oam_device')
            ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
            ->where('DevID', '=', $mac)
            ->first();
        return $deviceDetail;
    }

    public function getDevicePhysicInfoByMac($mac)
    {
        $types = array(
            '4-11-3',   //server的空闲CPU   参考oam_appmap中ID说明
            '4-11-4',   //server的总内存
            '4-11-5',   //server的空闲内存
            '4-12-6',   //CPU温度
            '4-12-7'    //系统温度
        );
        $devicePhysicInfo = array();
        foreach ($types as $type){
            $key = strtolower ( $type );
            $devicePhysicInfo[$key] = DB::table('oam_biteparamvalue')
                ->where('DeviceID', '=', $mac)
                ->where('ParamID', '=', $type)
                ->orderBy('CreateTime', 'desc')
                ->first();
            $format = new Formatter();
            switch ($key)
            {
                case "4-11-3":
                    $result["free_cpu"] = $format::formatPercentage($devicePhysicInfo["4-11-3"]->ParamValue);
                    break;
                case "4-11-4":
                    $result["total_memory"] = $format::formatDiskText($devicePhysicInfo["4-11-4"]->ParamValue);
                    break;
                case "4-11-5":
                    $result["free_memory"] = $format::formatDiskText($devicePhysicInfo["4-11-5"]->ParamValue);
                    break;
                case "4-12-6":
                    $result["cpu_temperature"] = $format::formatTemperature($devicePhysicInfo["4-12-6"]->ParamValue);
                    break;
                case "4-12-7":
                    if (isset($devicePhysicInfo["4-12-7"])) {
                        $result["system_temperature"] = $format::formatTemperature($devicePhysicInfo["4-12-7"]->ParamValue);
                    } else {
                        $result["system_temperature"] = $format::formatTemperature($devicePhysicInfo["4-12-6"]->ParamValue - 2);
                    }                    
                    break;
                default:
                    $result = '';
            }
        }

        return $result;
    }


    public function getDeviceHardDiskInfoByMac($mac)
    {
        $types = array(
            '/',
            '/opt',
            '/boot',
            '/dev/shm',
            '/usr/donica/update',
            '/opt/lampp/htdocs/files/program0',
            '/opt/lampp/htdocs/epg'
        );

        $hardDiskInfo = array();
        foreach ($types as $type){
            $key = strtolower ( $type );
            $hardDiskInfo[$key] = DB::table('oam_harddiskparam')
                ->where('DevID', '=', $mac)
                ->where('Partion', '=', $type)
                ->orderBy('CreateTime', 'desc')
                ->first();
            $format = new Formatter();
            switch ($key)
            {
                case "/":
                    $result[] = array(  "partion" => $hardDiskInfo['/']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/']->DiskPercent)
                    );
                    break;
                case "/opt":
                    $result[] = array(  "partion" => $hardDiskInfo['/opt']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/opt']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/opt']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/opt']->DiskPercent)
                    );
                    break;
                case "/boot":
                    $result[] = array(  "partion" => $hardDiskInfo['/boot']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/boot']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/boot']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/boot']->DiskPercent)
                    );
                    break;
                case "/dev/shm":
                    $result[] = array(  "partion" => $hardDiskInfo['/dev/shm']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/dev/shm']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/dev/shm']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/dev/shm']->DiskPercent)
                    );
                    break;
                case "/usr/donica/update":
                    $result[] = array(  "partion" => $hardDiskInfo['/usr/donica/update']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/usr/donica/update']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/usr/donica/update']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/usr/donica/update']->DiskPercent)
                    );
                    break;
                case "/opt/lampp/htdocs/files/program0":
                    $result[] = array(  "partion" => $hardDiskInfo['/opt/lampp/htdocs/files/program0']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/opt/lampp/htdocs/files/program0']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/opt/lampp/htdocs/files/program0']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/opt/lampp/htdocs/files/program0']->DiskPercent)
                    );
                    break;
                case "/opt/lampp/htdocs/epg":
                    $result[] = array(  "partion" => $hardDiskInfo['/opt/lampp/htdocs/epg']->Partion,
                        "avail" => $format::formatDiskText($hardDiskInfo['/opt/lampp/htdocs/epg']->DiskAvail),
                        "total" => $format::formatDiskText($hardDiskInfo['/opt/lampp/htdocs/epg']->DiskTotal),
                        "percent" => $format::formatPercentage($hardDiskInfo['/opt/lampp/htdocs/epg']->DiskPercent)
                    );
                    break;
                default:
                    $result = '';
            }
        }
        return $result;
    }

    public function getApplicationRunInfoByMac($mac)
    {
        $types = array(
            '4-1-1',   //server的空闲CPU   参考oam_appmap中ID说明
            '4-1-2',   //server的总内存
            '4-2-1',   //server的空闲内存
            '4-2-2',   //CPU温度
            '4-4-1',    //系统温度
            '4-4-2',   //server的空闲CPU   参考oam_appmap中ID说明
            '4-7-1',   //CPU温度
            '4-7-2',   //系统温度
        );
        $applicationInfo = array();
        foreach ($types as $type){
            $key = strtolower ( $type );
            $applicationInfo[$key] = DB::table('oam_biteparamvalue')
                ->where('DeviceID', '=', $mac)
                ->where('ParamID', '=', $type)
                ->orderBy('CreateTime', 'desc')
                ->first();
            $format = new Formatter();
            switch ($key)
            {
                case "4-1-1":
                    $result["CMD"] = $format::formatState($applicationInfo["4-1-1"]->ParamValue);
                    $result["CMD_status"] = $format::formatAppStatus($applicationInfo["4-1-1"]->ParamValue);
                    break;
                case "4-1-2":
                    $result["cmd__run_time"] = $format::formatTime($applicationInfo["4-1-2"]->ParamValue);
                    break;
                case "4-2-1":
                    $result["CMA"] = $format::formatState($applicationInfo["4-2-1"]->ParamValue);
                    $result["CMA_status"] = $format::formatAppStatus($applicationInfo["4-2-1"]->ParamValue);
                    break;
                case "4-2-2":
                    $result["cma__run_time"] = $format::formatTime($applicationInfo["4-2-2"]->ParamValue);
                    break;
                case "4-4-1":
                    $result["Suu"] = $format::formatState($applicationInfo["4-4-1"]->ParamValue);
                    $result["Suu_status"] = $format::formatAppStatus($applicationInfo["4-4-1"]->ParamValue);
                    break;
                case "4-4-2":
                    $result["suu__run_time"] = $format::formatTime($applicationInfo["4-4-2"]->ParamValue);
                    break;
                case "4-7-1":
                    $result["Arinc"] = $format::formatState($applicationInfo["4-7-1"]->ParamValue);
                    $result["Arinc_status"] = $format::formatAppStatus($applicationInfo["4-7-1"]->ParamValue);
                    break;
                case "4-7-2":
                    $result["arinc__run_time"] = $format::formatTime($applicationInfo["4-7-2"]->ParamValue);
                    break;
                default:
                    $result = '';
            }
        }
        return $result;
    }

    public function formatApplicationRunInfo($data)
    {
        $result[] = array("name" => 'CMD',
            "state" => $data['CMD'],
            "id" => 1,
            "status" => $data['CMD_status'],
            "run_time" => $data['cmd__run_time']);

        $result[] = array("name" => 'CMA',
            "state" => $data['CMA'],
            "id" => 2,
            "status" => $data['CMA_status'],
            "run_time" => $data['cma__run_time']);

        $result[] = array("name" => 'Suu',
            "state" => $data['Suu'],
            "id" => 3,
            "status" => $data['Suu_status'],
            "run_time" => $data['suu__run_time']);

        $result[] = array("name" => 'Arinc',
            "state" => $data['Arinc'],
            "id" => 4,
            "status" => $data['Arinc_status'],
            "run_time" => $data['arinc__run_time']);
        return $result;
    }

    public function getCapStatusInfoByMac($capPosition,$mac)
    {
        if ($capPosition == '0-ap-1'){
            $types = array(
                '15-1-65',   //2.4G的SSID
                '15-1-66',   //5G的SSID
                '15-1-69',   //CAP在线人数
                '15-1-70',   //CAP的2.4G频段在线人数
                '15-1-71',    //CAP的5G频段在线人数
                '15-1-73',    //CAP接收流量
                '15-1-74',    //CAP2.4G频段接收流量
                '15-1-75',    //CAP5G频段接收流量
                '15-1-77',    //CAP发送流量
                '15-1-78',    //CAP2.4G频段发送流量
                '15-1-79'    //CAP5G频段发送流量
            );
        }elseif ($capPosition == '0-ap-2'){
            $types = array(
                '15-2-65',   //2.4G的SSID
                '15-2-66',   //5G的SSID
                '15-2-69',   //CAP在线人数
                '15-2-70',   //CAP的2.4G频段在线人数
                '15-2-71',    //CAP的5G频段在线人数
                '15-2-73',    //CAP接收流量
                '15-2-74',    //CAP2.4G频段接收流量
                '15-2-75',    //CAP5G频段接收流量
                '15-2-77',    //CAP发送流量
                '15-2-78',    //CAP2.4G频段发送流量
                '15-2-79'    //CAP5G频段发送流量
            );
        }elseif ($capPosition == '0-ap-3'){
            $types = array(
                '15-3-65',   //2.4G的SSID
                '15-3-66',   //5G的SSID
                '15-3-69',   //CAP在线人数
                '15-3-70',   //CAP的2.4G频段在线人数
                '15-3-71',    //CAP的5G频段在线人数
                '15-3-73',    //CAP接收流量
                '15-3-74',    //CAP2.4G频段接收流量
                '15-3-75',    //CAP5G频段接收流量
                '15-3-77',    //CAP发送流量
                '15-3-78',    //CAP2.4G频段发送流量
                '15-3-79'    //CAP5G频段发送流量
            );
        }else{

        }

        $result = array();
        foreach ($types as $type){
            $key = strtolower ( $type );
            $result[$key] = DB::table('oam_biteparamvalue')
                ->where('DeviceID', '=', $mac)
                ->where('ParamID', '=', $type)
                ->orderBy('CreateTime', 'desc')
                ->first();
        }
        return $result;
    }


    public function formatCapStatusInfo($data,$capPosition)
    {
        $format = new Formatter();
        if ($capPosition == '0-ap-1'){
            $result[] = array(
                "name" => '2.4G_SSID',
                "value" => $data['15-1-65']->ParamValue
            );
            $result[] = array(
                "name" => '5G_SSID',
                "value" => $data['15-1-66']->ParamValue
            );
            $result[] = array(
                "name" => 'cap在线人数',
                "value" => $data['15-1-69']->ParamValue
            );
            $result[] = array(
                "name" => 'CAP的2.4G频段在线人数',
                "value" => $data['15-1-70']->ParamValue
            );
            $result[] = array(
                "name" => 'CAP的5G频段在线人数',
                "value" => $data['15-1-71']->ParamValue
            );
            $result[] = array(
                "name" => 'cap接收流量',
                "value" => $format::formatBytes($data['15-1-73']->ParamValue)
            );
            $result[] = array(
                "name" => 'cap发送流量',
                "value" => $format::formatBytes($data['15-1-77']->ParamValue)
            );
        }elseif ($capPosition == '0-ap-2'){
            $result[] = array(
                "name" => '2.4G_SSID',
                "value" => $data['15-2-65']->ParamValue
            );
            $result[] = array(
                "name" => '5G_SSID',
                "value" => $data['15-2-66']->ParamValue
            );
            $result[] = array(
                "name" => 'cap在线人数',
                "value" => $data['15-2-69']->ParamValue
            );
            $result[] = array(
                "name" => 'CAP的2.4G频段在线人数',
                "value" => $data['15-2-70']->ParamValue
            );
            $result[] = array(
                "name" => 'CAP的5G频段在线人数',
                "value" => $data['15-2-71']->ParamValue
            );
            $result[] = array(
                "name" => 'cap接收流量',
                "value" => $format::formatBytes($data['15-2-73']->ParamValue)
            );
            $result[] = array(
                "name" => 'cap发送流量',
                "value" => $format::formatBytes($data['15-2-77']->ParamValue)
            );
        }elseif ($capPosition == '0-ap-3'){
            $result[] = array(
                "name" => '2.4G_SSID',
                "value" => $data['15-3-65']->ParamValue
            );
            $result[] = array(
                "name" => '5G_SSID',
                "value" => $data['15-3-66']->ParamValue
            );
            $result[] = array(
                "name" => 'cap在线人数',
                "value" => $data['15-3-69']->ParamValue
            );
            $result[] = array(
                "name" => 'CAP的2.4G频段在线人数',
                "value" => $data['15-3-70']->ParamValue
            );
            $result[] = array(
                "name" => 'CAP的5G频段在线人数',
                "value" => $data['15-3-71']->ParamValue
            );
            $result[] = array(
                "name" => 'cap接收流量',
                "value" => $format::formatBytes($data['15-3-73']->ParamValue)
            );
            $result[] = array(
                "name" => 'cap发送流量',
                "value" => $format::formatBytes($data['15-3-77']->ParamValue)
            );
        }else{

        }
        return $result;

    }


    public function getFourGCardData(){
        $types = array(
            '4GNET',             //4G网络PING状态（取值于模块1模块2逻辑或）
            '4G1STA',            //4G模块1 拨号状态      1:CONNECT 0:DISCONNECT
            '4G1NET',            //4G模块1 网络PING状态  1:SUCCESS 0:FAILD
            '4G1SIG',            //4G模块1 RF信号强度
            '4G1ERR',            //4G模块1 拨号错误码
            '4G1IP',             //4G模块1 ppp0 IP地址
            '4G2STA',            //4G模块2 拨号状态
            '4G2NET',            //4G模块2 网络PING状态
            '4G2SIG',            //4G模块2 RF信号强度
            '4G2ERR',            //4G模块2 拨号错误码
            '4G2IP'              //4G模块2 ppp1 IP地址
        );
        $result = array();
        foreach ($types as $type){
            $key = strtolower ( $type );
            $result[$key] = DB::table('oam_dashboard_info')
                ->where('Available', '=', 1)
                ->where('Name', '=', $type)
                ->select('Name','Value')
                ->first();
        }
        return $result;
    }
}

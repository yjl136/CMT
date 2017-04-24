<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Syslog extends Model
{
    /**
     * @return mix
     * 得到操作日志的分页数据
     */
    public function getOperatePaginateData($content, $start_time, $end_time)
    {
        $result = null;
        if (!empty($content) && !empty($start_time) && !empty($end_time)) {
            $result = DB::table('cmt_operate')
                ->whereBetween('operate_time', [$start_time, $end_time])
                ->where('comment', 'like', "%$content%")
                ->orderBy('operate_time', 'desc')
                ->paginate(8);
        } else {
            $result = DB::table('cmt_operate')
                ->orderBy('operate_time', 'desc')
                ->paginate(8);
        }
        return $result;
    }


    /**
     * @return mixed
     * 得到拨号日志的分页数据
     */
    public function getDialPaginateData()
    {
        $result = DB::table('cmt_pppoe_log')
            ->orderBy('create_time', 'desc')
            ->paginate(8);
        return $result;
    }

    /**
     * @return mixed
     * 得到飞行日志的分页数据
     */
    public function getFlightPaginateData()
    {
        $result = DB::table('oam_flightinfodetail')
            ->leftJoin('oam_flightinfo', 'oam_flightinfodetail.FlightInfoID', '=', 'oam_flightinfo.ID')
            ->select('oam_flightinfodetail.ID', 'oam_flightinfo.FlightNumber', 'oam_flightinfodetail.Latitude', 'oam_flightinfodetail.Longitude', 'oam_flightinfodetail.DistanceToDestiation', 'oam_flightinfodetail.TimeToDestiation', 'oam_flightinfodetail.CreateDate')
            ->orderBy('CreateDate', 'desc')
            ->paginate(8);
        return $result;
    }

    /**
     * @return mixed
     * 得到告警日志的分页数据
     */
    public function getAlarmLogPaginateData($dev_type, $alarm_level, $clear_status, $start_time, $end_time)
    {
        $result = null;
        if (!empty($start_time) && !empty($end_time)) {
            $dev_type_op = $dev_type == -1 ? '<>' : '=';
            $alarm_level_op = $alarm_level == -1 ? '<>' : '=';
            $clear_status_op = $clear_status == -1 ? '<>' : '=';

            $result = DB::table('oam_alarmmessage')
                ->join('oam_device', 'oam_alarmmessage.DeviceID', '=', 'oam_device.DevID')
                ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
                ->select('oam_alarmmessage.ID', 'oam_alarmmessage.AlarmOccurTime', 'oam_alarmmessage.AlarmLevel', 'oam_alarmmessage.AlarmExtendInfo', 'oam_alarmmessage.AlarmProbalCause', 'oam_alarmmessage.ClearFlag', 'oam_devicecategory.Name')
                ->where('oam_device.DevType', $dev_type_op, $dev_type)
                ->where('oam_alarmmessage.AlarmLevel', $alarm_level_op, $alarm_level)
                ->where('oam_alarmmessage.ClearFlag', $clear_status_op, $clear_status)
                ->whereBetween('oam_alarmmessage.AlarmOccurTime', [$start_time, $end_time])
                ->orderBy('oam_alarmmessage.AlarmOccurTime', 'desc')
                ->paginate(8);
        } else {
            $result = DB::table('oam_alarmmessage')
                ->join('oam_device', 'oam_alarmmessage.DeviceID', '=', 'oam_device.DevID')
                ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
                ->select('oam_alarmmessage.ID', 'oam_alarmmessage.AlarmOccurTime', 'oam_alarmmessage.AlarmLevel', 'oam_alarmmessage.AlarmExtendInfo', 'oam_alarmmessage.AlarmProbalCause', 'oam_alarmmessage.ClearFlag', 'oam_devicecategory.Name')
                ->orderBy('oam_alarmmessage.AlarmOccurTime', 'desc')
                ->paginate(8);
        }
        return $result;
    }

    /**
     * @return mixed
     * 根据设备ID查询到所有的警告日志内容
     */
    public function getDeviceAlarmLogPaginateData($mac, $alarm_level, $clear_status, $start_time, $end_time)
    {
        $result = null;
        if (!empty($start_time) && !empty($end_time)) {
            $alarm_level_op = $alarm_level == -1 ? '<>' : '=';
            $clear_status_op = $clear_status == -1 ? '<>' : '=';
            $result = DB::table('oam_alarmmessage')
                ->join('oam_device', 'oam_alarmmessage.DeviceID', '=', 'oam_device.DevID')
                ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
                ->select('oam_alarmmessage.ID', 'oam_alarmmessage.AlarmOccurTime', 'oam_alarmmessage.AlarmLevel', 'oam_alarmmessage.AlarmExtendInfo', 'oam_alarmmessage.AlarmProbalCause', 'oam_alarmmessage.ClearFlag', 'oam_devicecategory.Name')
                ->where('oam_alarmmessage.DeviceID', '=', $mac)
                ->where('oam_alarmmessage.AlarmLevel', $alarm_level_op, $alarm_level)
                ->where('oam_alarmmessage.ClearFlag', $clear_status_op, $clear_status)
                ->whereBetween('oam_alarmmessage.AlarmOccurTime', [$start_time, $end_time])
                ->orderBy('oam_alarmmessage.AlarmOccurTime', 'desc')
                ->paginate(8);
        } else {
            $result = DB::table('oam_alarmmessage')
                ->join('oam_device', 'oam_alarmmessage.DeviceID', '=', 'oam_device.DevID')
                ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
                ->select('oam_alarmmessage.ID', 'oam_alarmmessage.AlarmOccurTime', 'oam_alarmmessage.AlarmLevel', 'oam_alarmmessage.AlarmExtendInfo', 'oam_alarmmessage.AlarmProbalCause', 'oam_alarmmessage.ClearFlag', 'oam_devicecategory.Name')
                ->where('oam_alarmmessage.DeviceID', '=', $mac)
                ->orderBy('oam_alarmmessage.AlarmOccurTime', 'desc')
                ->paginate(8);
        }
        return $result;
    }

    /**
     * @return mixed
     * 得到运行日志的分页数据
     */
    public function getRunningPaginateData($dev_type, $start_time, $end_time)
    {


        $result = null;
        if (!empty($dev_type) && !empty($start_time) && !empty($end_time)) {
            $dev_type_op = $dev_type == -1 ? '<>' : '=';
            $result = DB::table('oam_monitorparam')
                ->join('oam_application', 'oam_monitorparam.ApplicationID', '=', 'oam_application.ID')
                ->join('oam_paramtype', 'oam_monitorparam.ParamType', '=', 'oam_paramtype.ID')
                ->join('oam_monitorparamvalue', 'oam_monitorparam.ID', '=', 'oam_monitorparamvalue.ParamID')
                ->join('oam_devicecategory', 'oam_application.CategoryID', '=', 'oam_devicecategory.Type')
                ->select('oam_devicecategory.Name', 'oam_application.AppName', 'oam_monitorparamvalue.CreateTime', 'oam_monitorparamvalue.ParamValue', 'oam_application.AppType', 'oam_paramtype.TypeName', 'oam_paramtype.Descs')
                ->where('oam_devicecategory.Type', $dev_type_op, $dev_type)
                ->whereBetween('oam_monitorparamvalue.CreateTime', [$start_time, $end_time])
                ->orderBy('oam_monitorparamvalue.CreateTime', 'desc')
                ->paginate(8);
        } else {
            $result = DB::table('oam_monitorparam')
                ->join('oam_application', 'oam_monitorparam.ApplicationID', '=', 'oam_application.ID')
                ->join('oam_paramtype', 'oam_monitorparam.ParamType', '=', 'oam_paramtype.ID')
                ->join('oam_monitorparamvalue', 'oam_monitorparam.ID', '=', 'oam_monitorparamvalue.ParamID')
                ->join('oam_devicecategory', 'oam_application.CategoryID', '=', 'oam_devicecategory.Type')
                ->select('oam_devicecategory.Name', 'oam_application.AppName', 'oam_monitorparamvalue.CreateTime', 'oam_monitorparamvalue.ParamValue', 'oam_application.AppType', 'oam_paramtype.TypeName', 'oam_paramtype.Descs')
                ->orderBy('oam_monitorparamvalue.CreateTime', 'desc')
                ->paginate(8);
        }
        return $result;
    }

    /**
     * @param $logMsg
     * @param string $equipment
     * @return mixed
     * 记录下操作行为日志
     */
    public function saveOperation($logMsg, $equipment, $type)
    {

        $result = DB::table('cmt_operate')->insert(
            [
                'operate_time' => date('Y-m-d H:i:s', time()),    //操作时间
                'operater' => $type,                              //操作人
                'comment' => $logMsg,                             //操作描述
                'equipment' => $equipment                         //操作设备
            ]);
        return $result;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class System extends Model
{
    public function getDeviceList()
    {
        $result = DB::table('oam_device')
        ->join('oam_devicecategory', 'oam_device.DevType', '=', 'oam_devicecategory.Type')
        ->where('oam_device.DevType', '!=', '14')
        ->where('oam_device.DevType', '!=', '13')
        ->where('oam_device.DevType', '!=', '5')
        ->select('oam_device.*', 'oam_devicecategory.Name', 'oam_devicecategory.Descs')
        ->get();
        return $result;
    }

    public function getVersionInfo()
    {
        $result = DB::table('cmt_version')
            ->join('oam_devicecategory', 'cmt_version.DevType', '=', 'oam_devicecategory.Type')
            ->select('cmt_version.*', 'oam_devicecategory.Name', 'oam_devicecategory.Descs')
            ->get();
        return $result;
    }


    public function getUserByPassword($password)
    {
        $result = DB::table('cmt_admin_user')
            ->where('password', '=', $password)
            ->first();
        return $result;
    }
}

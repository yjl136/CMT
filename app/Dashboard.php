<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    public function getDashboardTableValue($type)
    {
        $result = DB::table('oam_dashboard_info')
            ->where('ID', '=', $type)
            ->select('Name', 'Value')
            ->get();
        return $result;
    }
}

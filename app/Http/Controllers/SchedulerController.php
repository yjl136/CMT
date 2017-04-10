<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Service\Data\DataService;

class SchedulerController extends Controller
{
    public function showAutoExport() {
        set_time_limit ( 0 );
        ini_set ( "memory_limit", "1024M" );
        $service = new DataService ();
        $airlineCompany = config('app.airline_company');
        if ($airlineCompany == "hna") {
            $service->autoExport ();
        } else if($airlineCompany == "la"){
            $service->exportDataOfLA ();
        }
        return "Task completed!";
    }
}

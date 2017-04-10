<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Syslog;

class SyslogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * operate log
     */
    public function operateLog(){
        $syslog = new Syslog;
        $operateList = $syslog->getOperatePaginateData();
        return view('syslog.operateLog',compact('operateList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * dial log
     */
    public function dialLog(){
        $syslog = new Syslog;
        $dialList = $syslog->getDialPaginateData();
        return view('syslog.dialLog',compact('dialList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * alarm log
     */
    public function alarmLog(){
        $syslog = new Syslog;
        $alarmLogList = $syslog->getAlarmLogPaginateData();
        return view('syslog.alarmLog',compact('alarmLogList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * running log
     */
    public function runningLog(){
        $syslog = new Syslog;
        $runningList = $syslog->getRunningPaginateData();
        return view('syslog.runningLog',compact('runningList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * flight log
     */
    public function flightLog(){
        $syslog = new Syslog;
        $flightList = $syslog->getFlightPaginateData();
        return view('syslog.flightLog',compact('flightList'));
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

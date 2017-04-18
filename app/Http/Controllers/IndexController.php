<?php

namespace App\Http\Controllers;

use App\Http\Service\Log\SessionLog;
use App\Http\Service\Maintain;
use App\Http\Service\System\SystemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\System;
use App\Syslog;

class IndexController extends Controller
{
    /**
     *  用密码登录系统，自动根据用户密码判断用户类型
     */
    function loginWithPassword(Request $request) {
        $password = $request->get('password');             //获取到ajax的post提交过来的数据，然后进行哈希加密
        $users = new System;
        $user = $users->getUserByPassword ( $password );      //根据密码查询数据库中用户的类型
        $name = decrypt($user->name);
        $type = $user->type;
        if ($user){
            $request->session()->put('cmt_user_name', $name);  //存取session数据
            $request->session()->put('cmt_user_type', $type);

            SessionLog::log("login>>  cmt_user_name: ".$request->session()->get('cmt_user_name')."   cmt_user_type:".$request->session()->get('cmt_user_type'));

            $log = new Syslog;
            $log->saveOperation ( "User " . $request->session()->get('cmt_user_type') . " login ", 'Server', $request->session()->get('cmt_user_name') );     // 记录操作日志
            return response()->json($type);
        }else{
            return response()->json("error");
        }
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 用户退出操作，并清除掉session中的用户数据
     */
    function logout(Request $request) {
        $log = new Syslog;
        SessionLog::log("logout>>  cmt_user_name: ".$request->session()->get('cmt_user_name')."   cmt_user_type:".$request->session()->get('cmt_user_type'));


        if (empty($request->session()->get('cmt_user_name')) || empty($request->session()->get('cmt_user_type'))) {
           // $log->saveOperation ( "User " . $request->session()->get('cmt_user_type')  . " logout", 'Server', $request->session()->get('cmt_user_name') );  // 记录操作日志
            $request->session()->flush();    //清空session中的所有数据
            Maintain::switchWifiMode(0,false);
            return redirect('/');    //执行跳转到登录页面
        }else{
            $log->saveOperation ( "User " . $request->session()->get('cmt_user_type')  . " logout", 'Server', $request->session()->get('cmt_user_name') );  // 记录操作日志
            $request->session()->flush();    //清空session中的所有数据
            Maintain::switchWifiMode(0,false);
            return redirect('/');    //执行跳转到登录页面
        }



    }
}

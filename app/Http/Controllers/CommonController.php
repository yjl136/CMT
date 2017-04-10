<?php

namespace App\Http\Controllers;

use App\Http\Service\Update\UpdateService;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function showError(Request $request) {
        $list = array();
        $type = $request->input("type");
        $text = $request->input("text");
        $func = $request->input("func");
        $msg = $request->input("msg");
        $msg = htmlspecialchars_decode($msg);
        $msg = str_replace("&amp;lt;br/&amp;gt;", "<br/>", $msg);
        $msg = str_replace("&amp;gt;", ">", $msg);
        $icon_css = $type == "success" ? "icoPop" : "icoFail";
        $msg_css = $type == "success" ? "" : "redMessage";
        array_push($list,$icon_css);
        array_push($list,$msg_css);
        array_push($list,$msg);
        if((!empty($text)) && (!empty($func))){
            array_push($list,$func+"();");
            array_push($list,$text);
        }else{
            array_push($list,"init();");
            array_push($list,trans('maintain.back'));
        }
        $tem="<div class=\"blockBox mtop10\"><p class=\"message\"><i class=\"%s\"></i><span class=\"%s\">%s</span></p><p class=\"subBox\"><a href=\"#\" class=\"Buton\" onclick=\"%s\">%s</a></p></div>";
        return vsprintf($tem,$list);
    }

    public function showProgError(Request $request){
        $type = $request->input("type");
        $text = $request->input("text");
        $func = $request->input("func");
        $error_msg = $request->input("msg");
        $icon_css = $type == "success" ? "icoPop" : "icoFail";
        $msg_css = $type == "success" ? "" : "redMessage";
        $btn_list = array();
        if((!empty($text)) && (!empty($func))){
            array_push($btn_list, array("btn_text"=>trans($text), "btn_func"=>$func));
        }
        array_push($btn_list, array("btn_text"=>trans("返回"), "btn_func"=>"init"));
        $service = new UpdateService();
        $error_log = $service->getProgErrorLog();
        return view('common.progError',compact('icon_css','msg_css','error_msg','btn_list','error_log'));

    }

    public function showMenuGroup(){
        $url = $_GET["url"];
        $query_array = parse_url($url, PHP_URL_QUERY);
        if($query_array !== false){
            echo sprintf("%s('config')", $_GET["callback"], $query_array["group"]);
        }
        $this->exitSystem();
    }

}

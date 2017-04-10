<?php

namespace App\Http\Controllers;

use App\Http\Service\Maintain;
use App\Http\Service\Utils\ConvertHelper;
use App\Http\Service\Utils\UpdateWays;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * @param $way
     * 检查传输方法
     */
    public function showCheckTransWay($way) {
        $result = Maintain::checkTransWay($way);
        echo json_encode ( $result );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 数据导出
     */
    public function dataExport() {
        $transWays=UpdateWays::getTransWays();
        $formatTypes=UpdateWays::getFormatTypes();
        return view('data.dataExport',compact('transWays','formatTypes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 自动导出
     */
    public function autoExport() {
        $result = Maintain::getAutoExportConfigValue ();
        $list = ConvertHelper::object2array($result[0]);
        return view('data.autoExport',compact('list'));
    }

    /**
     * @param $exportTactics
     * @param $exportDays
     * @param $exportWeeks
     * @param $exportMonths
     * @param $exportInputChecked
     * 自动导出参数设置
     */
    public function showAutoExportConfig($exportTactics,$exportDays,$exportWeeks,$exportMonths,$exportInputChecked) {
        Maintain::autoExportConfig($exportTactics,$exportDays,$exportWeeks,$exportMonths,$exportInputChecked);
        return response()->json("success");
    }


    public function showExportData($way=1,$format_type=1,$start_time='',$end_time='') {
       $params = array (
            "way" => $way,
            "format_type" => $format_type,
            "start_time" => $start_time,
            "end_time" => $end_time
        );
       $result =Maintain::exportData($params);
       echo json_encode ( $result );
    }

    public function showQueryProgress($way,$content_type,$format_type,$start_time,$end_time) {
        $result=Maintain::queryExportDataProgress($way,$content_type,$format_type,$start_time,$end_time);
        echo json_encode ( $result );

    }

    public function showLogExport(){
        $result  = $this->_service->logExport();
        echo json_encode($result);
        $this->exitSystem();
    }

    public function showDataImport() {
        if ($_GET ["do"] == "import") {
            $result = $this->_service->importData($_GET ["way"]);
            Log::write ( "Import data result === " . json_encode ( $result ), Log::DEBUG );
            echo json_encode ( $result );
            $this->exitSystem ();
        }

        $this->display ();
    }

    public function showAttemptWriteFile() {
        $result = $this->_service->attemptWriteFile();

        echo json_encode($result);
        $this->exitSystem();
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

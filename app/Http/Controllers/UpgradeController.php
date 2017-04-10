<?php

namespace App\Http\Controllers;

use App\Http\Service\Configs;
use App\Http\Service\Consts;
use App\Http\Service\Maintain;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

class UpgradeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 渲染多尼卡系统升级页面
     */
    public function sysUpgrade() {
        return view('upgrade.sysUpgrade');
    }

    /**
     * @return string
     * 检查传输方法
     */
    public function showCheckTransWay($way=1) {
        $result= Maintain::CheckTransWay($way);
        echo json_encode ( $result );
    }

    /**
     * @return string
     * 执行系统升级
     */
    public function showQuerySysUpdate() {
        $result= Maintain::querySysUpdate();
        echo json_encode ( $result );
    }

    /**
     * @return string
     * 查询系统升级的版本
     */
    public function showQueryVersion() {
        $list= Maintain::queryVersion();
        echo json_encode ( $list );
    }

    /**
     * @return string
     * 拷贝系统升级包
     */
    public function showCopyPackage() {
        $result=Maintain::copyPackage();
        echo json_encode ( $result );
    }

    public function showQueryCopyProgress() {
        $result =Maintain::queryCopyProgress();
        echo json_encode ( $result );
    }

    public function showStartUpdate($target=null) {
        $result = Maintain::startUpdate($target);
        echo json_encode ( $result );
    }

    public function showQuerySysUpdateProgress($target=null) {
        $result = Maintain::querySysUpdateProgress($target);
        echo json_encode ( $result );

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 部件升级
     */
    public function devUpgrade() {
        return view('upgrade.devUpgrade');
    }

    public function showQueryDevUpdate() {
        $result =Maintain::queryDevUpdate();
        echo json_encode ( $result );
    }

    public function showReboot($target) {
        $result =Configs::reboot($target);
        echo json_encode ( $result );

    }


    public function sysBackup($do=null) {
       if ($do == "backup") {
           $result = Maintain::sysBackup();
         //  $this->saveOperation ( "backup [" . $_SESSION ['cmt_user_type'] . "] start " );
           echo json_encode ( $result );
        } else if ($do == "query") {
           $result = Maintain::queryBackupProgress();
            echo json_encode ( $result );
       }else{
           return view('upgrade.sysBackup');
       }

    }

    public function progUpdate() {
        return view('upgrade.progUpdate');
    }



    public function showQueryProgUpdate($way) {
        $result = Maintain::queryProgUpdate($way);
        echo json_encode ( $result );
        //$this->exitSystem ();
    }

    public function showQueryProgVersion() {
        $list = Maintain::queryProgVersion();
        echo json_encode ( $list );
       // $this->exitSystem ();
    }

    public function showStartProgUpdate($way) {
        $result =Maintain::startProgUpdate($way);
        echo json_encode ( $result );
       // $this->exitSystem ();
    }

    public function showQueryProgUpdateProgress($way) {
        $result = Maintain::queryProgUpdateProgress($way);
        echo json_encode ( $result );
      //  $this->exitSystem ();
    }

    public function showCleanup() {
        $result =Maintain::cleanup();
        echo json_encode ( $result );
    }

    public function init() {
        // 验证是否登录
        check_login ();

        parent::init ();

        $this->_service = new UpdateService();
        $this->_thirdService = new ThirdUpdateService();

        $this->setLeftMenu ( 'maintenance' );
    }










    /**
     * 第三方南航的升级操作区域
     * 一共分为7个步骤
     */
    public function showThirdSysUpdate() {
        $update_ways = $this->_service->getThirdUpdateWays();
        $this->Tmpl["update_ways"] = $update_ways;
        $this->Tmpl["default_way"] = $this->_service->getDefaultWay();
        $this->setLeftMenu ( 'maintenance' );
        $this->changeMenuKey ();
        $this->setSubMenu ( 'upgrade' );
        $this->display ();
    }

    /**
     * 检查页面选中的升级方式（包括USB,HTTP,FTP)
     */
    public function showCheckedWay() {
        $way = $_GET ["way"];
        $result = $this->_thirdService->checkedWay ( $way );
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 执行第三方系统升级
     */
    public function showQueryThirdSysUpdate() {
        $way = $_GET ["way"];
        $result = $this->_thirdService->checkThirdVersion ($way);
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 通过socket获取到升级的版本信息（包括，旧版与新版）
     */
    public function showQueryThirdVersion() {
        $list = $this->_thirdService->queryThirdVersion ();
        echo json_encode ( $list );
        $this->exitSystem ();
    }

    /**
     * 开始第三方升级包的拷贝工作
     */
    public function showCopyThirdPackage() {
        $result = $this->_thirdService->startCopyPackage ();
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 展示拷贝过程中的进度
     */
    public function showCopyThirdPackageProgress() {
        $result = $this->_thirdService->queryThirdProgress ();
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 开始第三方系统升级
     */
    public function showStartThirdUpdate() {
        $result = $this->_thirdService->startThirdUpdate ();
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 展示第三方升级过程中进度
     */
    public function showStartThirdUpdateProgress() {
        $result = $this->_thirdService->queryThirdStartProgress ();
        echo json_encode ( $result );
        $this->exitSystem ();
    }













    /**
     * 第三方节目更新
     */
    public function showThirdProgUpdate() {
        $update_ways = $this->_service->getThirdProgramUpdateWays();
        $this->Tmpl["update_ways"] = $update_ways;
        $this->Tmpl["default_way"] = $this->_service->getDefaultWay();
        $this->setLeftMenu ( 'maintenance' );
        $this->changeMenuKey ();
        $this->setSubMenu ( 'proUpdate' );
        $this->display ();
    }

    /**
     *检查节目更新方式的方式状态
     */
    public function showCheckedProgWay() {
        $way = $_GET ["way"];
        $result = $this->_thirdService->checkedProgWay ( $way );
        echo json_encode ( $result );
        return $way;
    }

    /**
     * 发送信令查询节目更新包的信息
     * 从url传入节目更新方法
     */
    public function showQueryThirdProgVersion() {
        $way = $_GET ["way"];
        $result = $this->_thirdService->checkThirdProgVersion ($way);
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 节目更新包符合要求，执行节目更新，开始拷贝节目包
     */
    public function showStartThirdProgCopy() {
        $list = $this->_thirdService->startCopyProgPackage ();
        echo json_encode ( $list );
        $this->exitSystem ();
    }

    /**
     * 发送信令实时查询拷贝节目更新包的进度
     */
    public function showStartThirdProgCopyProgress() {
        $result = $this->_thirdService->selectThirdProgCopyProgress ();
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 开始节目更新
     */
    public function showStartThirdProgUpdate() {
        $result = $this->_thirdService->startThirdProgUpdate ();
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    /**
     * 发送信令实时查询更新节目包的进度，更新成功并提示成功信息
     */
    public function showStartThirdProgUpdateProgress() {
        $result = $this->_thirdService->selectThirdProgUpdateProgress ();
        echo json_encode ( $result );
        $this->exitSystem ();
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

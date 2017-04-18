<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/4/13
 * Time: 16:45
 */

namespace App\Http\Service\Config;


use App\Device;
use App\Http\Service\Consts;
use Illuminate\Support\Facades\DB;

class DiagnoseService
{

    private $wowStatus;
    private $altitude;

    /**
     * @return mixed
     * 自检
     */
    public function diagnose() {
        $this->setDiagnoseStatus (Consts::DIAGNOSE_STATUS_NAME, Consts::DIAGNOSE_STATUS_PROCESSING );
        $status = $this->_diagnose ();
        if ($status != Consts::DIAGNOSE_STATUS_NORMAL) {
            sleep ( 5 );
            $status = $this->_diagnose ();
        }
        $this->setDiagnoseStatus (Consts::DIAGNOSE_STATUS_NAME, $status );
        return $this->getDiagnoseStatus (Consts::DIAGNOSE_STATUS_NAME);
    }

    /**
     * @param $name
     * @param $status
     * 更新自检状态
     */
    public function setDiagnoseStatus($name,$status) {
        $sql = "UPDATE " . Consts::CMT_CONFIG . " SET var_value = ? WHERE var_name = ? LIMIT 1";
        DB::update($sql,[$status,$name]);
    }

    /**
     * 获取自检值状态值
     */
    public function getDiagnoseStatus($name) {
        $sql = "SELECT var_value FROM " . Consts::CMT_CONFIG . " WHERE var_name = '$name' LIMIT 1";
        $result=DB::select($sql);
        return $result[0]->var_value;
    }

    /**
     * 获取到wow状态
     */
    public function getWoW(){
        $result = $this->getDashboardValue('WoW');
        return $result->Value;
    }
    public function getDashboardValue($name) {
        $sql = "SELECT Value FROM " . Consts::OAM_DASHBOARD_INFO . " WHERE Available = '1' AND Name = '$name' LIMIT 1";
        $result = DB::select($sql);
        return $result[0];
    }
    /**
     * 获取高度
     */
    public function getAltitude(){
        $result = $this->getDashboardValue('Altitude');
        return $result->Value;
    }

    public function get4GModuleState(){
        $result = $this->getDashboardValue('4G');
        return $result->Value;
    }

    public function get4GSwitchState(){
        $result = $this->getDashboardValue('4GSwitch');
        return $result->Value;
    }
    public function clearTroubleMessage($type){
        $sql = "UPDATE " . Consts::OAM_TROUBLE_MESSAGE . " SET Visible = 0, CreateTime = NOW()" .  " WHERE Type = ?";
        DB::update($sql,[$type]);
    }
    public  function  getCapStatus(){
        $sql="select * from ".Consts::OAM_DEVICE."  where DevType='15'";
        $status=DB::select($sql);
        return $status;
    }
    private function _diagnose() {
        switch ($this->getDiagnoseStatus (Consts::DIAGNOSE_STATUS_NAME)) {
            case Consts::DIAGNOSE_STATUS_IDLE :
            case Consts::DIAGNOSE_STATUS_PROCESSING :
            case Consts::DIAGNOSE_STATUS_NORMAL :
            case Consts::DIAGNOSE_STATUS_ABNORMAL :
            case Consts::DIAGNOSE_STATUS_FAILED :
                $this->wowStatus = $this->getWoW ();
                $this->altitude = $this->getAltitude ();
                $result = array (
                    $this->diagnose4G (),
                    $this->diagnoseWiFi ()
                );

                $status = max ( $result );
                break;

            default :
                $status = Consts::DIAGNOSE_STATUS_NORMAL;
                break;
        }
        return $status;
    }

    /**
     * @return int
     * 4G自检
     */
    private function diagnose4G() {
        $status = Consts::DIAGNOSE_STATUS_NORMAL;
        if ($this->wowStatus) {
            $status = $this->diagnose4GModuleStatus ();
        } else {
            $this->clearTroubleMessage ( Consts::DIAGNOSE_TYPE_4G );
        }
        return $status;
    }
    private function diagnoseWiFi() {
        $status = Consts::DIAGNOSE_STATUS_NORMAL;
        $this->clearTroubleMessage ( Consts::DIAGNOSE_TYPE_WIFI );

       /* $wifi_status = $this->wifiAdapter->getWiFiStatusBySnmp ();


        if ($this->wowStatus || $this->altitude > $this->_getHeightThrehold ()) {
            $status = $wifi_status ? $this->_diagnoseCAP () : Consts::DIAGNOSE_STATUS_FAILED;
        }*/

        if($this->wowStatus || $this->altitude > $this->getHeightThrehold ()){
            $status_list=$this->getCapStatus();
            if (count ( $status_list )) {
                $status = Consts::DIAGNOSE_STATUS_NORMAL;
                foreach ( $status_list as $device ) {
                    if ($device->DevStatus != 2) {
                        $status = Consts::DIAGNOSE_STATUS_ABNORMAL;
                        break;
                    }
                }
            } else {
                $status = Consts::DIAGNOSE_STATUS_FAILED;
            }
        }

        switch ($status) {
            case Consts::DIAGNOSE_STATUS_ABNORMAL :
                $this->notifyTroubleMessage ( Consts::DIAGNOSE_TYPE_WIFI, Consts::CAP_STATUS_ABNORMAL );
                break;

            case Consts::DIAGNOSE_STATUS_FAILED :
                $this->notifyTroubleMessage ( Consts::DIAGNOSE_TYPE_WIFI, Consts::CAP_STATUS_FAILED );
                break;

            default :
                $this->clearTroubleMessage ( Consts::DIAGNOSE_TYPE_WIFI );
                break;
        }
        return $status;
    }

    private function getHeightThrehold() {
        $height_threhold = Consts::DEFAULT_HEIGHT_THREHOLD;
        $file = Consts::APP_CONFIG_XML;
        if (file_exists ( $file )) {
            $xml = simplexml_load_file ( $file );
            $result=$xml->xpath ( "hight_threshold" );
            $height_threhold = "" . array_shift ($result);
            $height_threhold = intval ( $height_threhold );
        } else {
            $file = Consts::APP_CONFIG_INI;
            if (file_exists ( $file )) {
                $config_array = parse_ini_file ( $file );
                $height_threhold = intval ( $config_array ["hight_threshold"] );
            }
        }
        return $height_threhold;
    }


    private function diagnose4GModuleStatus(){
        $status = Consts::DIAGNOSE_STATUS_NORMAL;
        $this->clearTroubleMessage ( Consts::DIAGNOSE_TYPE_4G );
        if(!$this->get4GSwitchState()){
            $trouble_code = Consts::W4G_ERR_SWITCH_CLOSE;
        }else{
            $trouble_code = $this->get4GModuleState ();
        }

        switch ($trouble_code) {
            case Consts::W4G_ERR_DIAL_FAILED:
            case Consts::W4G_ERR_RECV_AT_CMD_FAILED:
            case Consts::W4G_ERR_NOT_FOUND_DIAL_LOG:
            case Consts::W4G_ERR_UNKNOWN :
                $status = Consts::DIAGNOSE_STATUS_ABNORMAL;
                $this->notifyTroubleMessage ( Consts::DIAGNOSE_TYPE_4G, Consts::W4G_ERR_DIAL_FAILED_CODE);
                break;
            case Consts::W4G_ERR_SWITCH_CLOSE:
                //被关闭了
                $status = Consts::DIAGNOSE_STATUS_ABNORMAL;
                $this->notifyTroubleMessage ( Consts::DIAGNOSE_TYPE_4G, Consts::W4G_ERR_SWITCH_CLOSE_CODE );
                break;

            case Consts::W4G_ERR_SIM_NONE:
                //被关闭了
                $status = Consts::DIAGNOSE_STATUS_ABNORMAL;
                $this->notifyTroubleMessage ( Consts::DIAGNOSE_TYPE_4G, Consts::W4G_ERR_SIM_CARD_NOT_FOUND_CODE );
                break;
             case Consts::W4G_ERR_NO_SIGNAL :
             case Consts::W4G_ERR_OUT_OF_SERVICE:
                //被关闭了
                $status = Consts::DIAGNOSE_STATUS_ABNORMAL;
                $this->notifyTroubleMessage ( Consts::DIAGNOSE_TYPE_4G, Consts::W4G_ERR_NO_SIGNAL_CODE );
                break;
            default :
                $this->clearTroubleMessage (Consts::DIAGNOSE_TYPE_4G);
                break;
        }
        return $status;
    }
    private function notifyTroubleMessage($type, $trouble_code) {
        $sql = "UPDATE " . Consts::OAM_TROUBLE_MESSAGE . " SET Visible = 1, CreateTime = NOW() WHERE Type = ? AND TroubleCode = ?";
        DB::update($sql,[$type, $trouble_code]);
    }

}
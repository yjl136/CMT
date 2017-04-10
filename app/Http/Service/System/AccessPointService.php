<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/7
 * Time: 11:17
 */

namespace App\Http\Service\System;
use App\Http\Service\Base\BaseService;
use App\Http\Service\Consts;
use App\Http\Service\Db\AccessPointDAO;
use App\Http\Service\Db\ExtDeviceDAO;
use App\Http\Service\Utils\Formatter;

class AccessPointService extends  BaseService
{
    private $apDAO;
    private $deviceDAO;

    public function __construct() {
        $this->apDAO = new AccessPointDAO ();

        $this->deviceDAO = new ExtDeviceDAO ();
    }

    public function getAPList() {
        switch (Consts::AP_MODE_DEFAULT) {
            case Consts::AP_MODE_CAP2K :
                $list = $this->_getDeviceList ( Consts::DEV_TYPE_CAP );
                break;

            case Consts::AP_MODE_KONTRON :
                $list = $this->_getDeviceList ( Consts::DEV_TYPE_CAP_KONTRON );
                break;

            default :
                $list = $this->apDAO->getAPList ();
                break;
        }
        return $list;
    }

    private function _getDeviceList($dev_type) {
        $list = $this->deviceDAO->getDeviceListByDevType ( $dev_type );
        foreach ( $list as $key => $value ) {
         /*   $list [$key] ["Name"] = Formatter::formatDeviceName ( $value ["DevType"], $value ["Name"], $value ["DevPosition"] );
            $list [$key] ["PositionID"] = str_replace ( '0-ap-', "", $value ["DevPosition"] );
            $list [$key] ["Mac"] = $value ["DevID"];
            $list [$key] ["Status"] = $value ["DevStatus"] == 2 ? 1 : 0;
            $list [$key] ["StatusText"] = Formatter::formatDeviceStatus ( $value ["DevStatus"] );*/
           $list [$key] ->Name = Formatter::formatDeviceName ( $value->DevType, $value->Name, $value->DevPosition );
            $list [$key]->PositionID = str_replace ( '0-ap-', "", $value ->DevPosition);
            $list [$key]->Mac= $value->DevID;
            $list [$key]->Status = $value->DevStatus == 2 ? 1 : 0;
            $list [$key]->StatusText= Formatter::formatDeviceStatus ( $value ->DevStatus);
        }
        return $list;
    }

    private function _getAPList() {
        include_once 'lib/Common/AccessPointFormatter.php';
        $formatter = new AccessPointFormatter ();

        $list = $this->apDAO->getAPList ();
        foreach ( $list as $key => $value ) {
            $status = $formatter->formatAPStatus ( $value ["OperationalState"] );
            $list [$key] ["Status"] = $status;
            $list [$key] ["StatusText"] = $formatter->formatAPStatusText ( $status );
        }
        return $list;
    }

    public function getAP($ip) {
        return $this->apDAO->getAP ( $ip );
    }

    public function updateAP($ip, $params) {
        return $this->apDAO->updateAP ( $ip, $params );
    }

    public function deleteAP($ip) {
        return $this->apDAO->deleteAP ( $ip );
    }
}
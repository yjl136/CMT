<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/8
 * Time: 17:53
 */

namespace App\Http\Service\Config;


use App\Http\Service\Base\BaseService;
use App\Http\Service\Db\CactiDAO;
use App\Http\Service\Db\ExtDeviceDAO;

class CactiService extends BaseService
{
    private $cactiDAO;

    public function __construct() {
        $this->cactiDAO = new CactiDAO ();
    }

    /**
     * 是否支持图形监控
     * 注意：目前支持图形监控的类型只有CMT Server和APs
     *
     * @param integer $dev_type
     * @return boolean
     */
    public function isSupport($dev_type) {
        return $this->cactiDAO->isSupport ( $dev_type );
    }

    /**
     * 获取时间间隔列表，用于图形监控页面切换的菜单选项
     *
     * @return array<integer, string>
     */
    public function getTimePeriods($dev_type) {
        return $this->cactiDAO->getTimePeriods ( $dev_type );
    }

    /**
     * 获取图形类型列表，用于图形监控页面切换的菜单选项
     *
     * @param integer $dev_type
     * @return array<integer, string>
     */
    public function getGraphTypes($dev_type) {
        return $this->cactiDAO->getGraphTypes ( $dev_type );
    }

    /**
     * 根据主机IP地址和图形模板类型，获取指定时间范围内的统计图形url列表
     *
     * @param string $host
     * @param integer $graph_template_id
     * @param integer $time_period
     * @param integer $width
     * @param number $height
     * @return array: 图片url数组
     */
    public function getGraphUrls($dev_id, $graph_template_id, $time_period, $width = 900, $height = 480) {
        $deviceDAO = new ExtDeviceDAO ();
        $device = $deviceDAO->getDevice ( $dev_id );
        return $this->cactiDAO->getGraphUrls ( $device ["IPAddress"], $graph_template_id, $time_period, $width, $height );
    }

    public function resetPollerLastRunTime($time) {
        return $this->cactiDAO->resetPollerLastRunTime ( $time );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 10:42
 */

namespace App\Http\Service\Update;


use App\Http\Service\Consts;

class PdlUpdateService extends  ProgramUpdateService
{
    public function checkVersion() {
        return $this->_checkVersion ( Consts::UPDATE_QUERY_ITEM_PDL, "checkVersionCallback" );
    }

    public function start($target) {
        $target = Consts::TARGET_SERVER;
        $site = $this->_getSite ( $target );
        $param = array (
            "site" => $site,
            "item" => Consts::COPY_FROM_PDL
        );
        return $this->_start ( Consts::CMD_START_PROG_UPDATE, $target, $param );
    }

    public function queryProgress($target) {
        return $this->_queryProgress ( Consts::TARGET_SERVER, Consts::COPY_FROM_PDL, "progressCallBack" );
    }
}
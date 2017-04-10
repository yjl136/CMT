<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/3/13
 * Time: 11:40
 */

namespace App\Http\Service\Update;

use App\Http\Service\Base\BaseService;
use App\Http\Service\Consts;
use App\Http\Service\Log\Log;

class UpdateService extends BaseService
{
    public function getProgErrorLog() {
        $update_log = Consts::UPDATE_DONE_SRC . Consts::UPDATE_LOG_FILE;
        if (file_exists ( $update_log ) && is_file ( $update_log )) {
            $doc = new \DOMDocument();
            $doc->load ( $update_log );

            $version_node = $doc->getElementsByTagName ( "version" )->item ( 0 );
            $createtime_node = $doc->getElementsByTagName ( "createtime" )->item ( 0 );
            $updatetime_node = $doc->getElementsByTagName ( "updatetime" )->item ( 0 );
            $video_node = $doc->getElementsByTagName ( "video" )->item ( 0 );
            $audio_node = $doc->getElementsByTagName ( "audio" )->item ( 0 );
            $result ["version"] = $version_node->nodeValue;
            $result ["create_time"] =$this-> dateToString ( intval ( $createtime_node->nodeValue ) );
            $result ["update_time"] =$this->dateToString( intval ( $updatetime_node->nodeValue ) );
            $video_log = $video_node->nodeValue . "";
            Log::write ( "Read video log : $video_log", Log::DEBUG );
            ! empty ( $video_log ) && $result ["video_list"] = $this->_getMediaFileList ( sprintf ( "%s%s", Consts::UPDATE_SRC, $video_log ) );
            $audio_log = $audio_node->nodeValue . "";
            Log::write ( "Read audio log : $audio_log", Log::DEBUG );
            ! empty ( $audio_log ) && $result ["audio_list"] = $this->_getMediaFileList ( sprintf ( "%s%s", Consts::UPDATE_SRC, $audio_log ) );
            $result ["code"] = Consts::CODE_SUCCESS;
        } else {
            $result ["code"] =Consts:: CODE_FAILURE;
            $result ["msg"] = "错误日志信息文件不存在！";
        }
        return $result;
    }
    public function dateToString($date , $format = "Y-m-d"){
        $datetime = date($format, empty($date) ? time() : $date);
        return $datetime;
    }

    public function _getMediaFileList($media_log) {
        Log::write ( "Read media log : $media_log", Log::DEBUG );
        $list = array ();
        if (file_exists ( $media_log ) && is_file ( $media_log )) {
            $doc = new \DOMDocument();
            $doc->load ( $media_log );
            $file_node_list = $doc->getElementsByTagName ( "file" );
            for($i = 0; $i < $file_node_list->length; $i ++) {
                $list [] = $file_node_list->item ( $i )->nodeValue;
            }
        }
        return $list;
    }
}
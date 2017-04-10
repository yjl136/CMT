<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 10:43
 */

namespace App\Http\Service\Update;


use App\Http\Service\Consts;
use App\Http\Service\Base\BaseUpdateService;
use App\Http\Service\Db\DBHelper;
use App\Http\Service\Log\Log;
use App\Http\Service\Tcp\CommandHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


class ProgramUpdateService extends BaseUpdateService
{
    public function checkVersion() {
        return $this->_checkVersion ( Consts::UPDATE_QUERY_ITEM_USB, "checkVersionCallback" );
    }

    public function checkVersionCallback($result) {
        if ($result ["code"] == Consts::CODE_SAME_PKG_UNCOMPLETED) {
             if (! $this->_isProgramUpdateCompleted ()) { // 更新包相同，上次未完成，当做新更新包重新更新，可以断点续传
            $result ["code"] = Consts::CODE_NEW_PACKAGE;
            $result ["unfinished"] = true;
             }
        }

        // 海航的节目包数据库名为cmt_wifi,epg_wifi，而系统中使用的是cmt,epg
        if ($result ["code"] == Consts::CODE_NEW_PACKAGE) {
            $this->_changeDBName ();
        }
    }

    protected function _isProgramUpdateCompleted() {
        $update_log = Consts::UPDATE_SRC .Consts::UPDATE_LOG_FILE;
        if (file_exists ( $update_log )) {
            $doc = new \DOMDocument();
            $doc->load ( $update_log );
            $media_node = $doc->getElementsByTagName ( 'media' )->item ( 0 );
            return trim ( $media_node->nodeValue ) ? false : true;
        }
        return true;
    }

    protected function _changeDBName() {
        $update_xml = Consts::UPDATE_SRC .Consts::PROGRAM_CFG_FILE;

       // $document = new DOMDocument ();
        $document = new \DOMDocument();

        $document->load ( $update_xml );

        $epg_elements = $document->getElementsByTagName ( 'epg' );

        if ($epg_elements->length > 0) {
            foreach ( $epg_elements as $element ) {
                $names = $element->getElementsByTagName ( "name" );
                $dbnames = $element->getElementsByTagName ( "dbname" );
                if ($names->length > 0) {
                    $name = $names->item ( 0 )->nodeValue;
                    if (strcasecmp ( $name, "cmt" ) == 0) {
                        if ($dbnames->length){
                            $dbnames->item ( 0 )->nodeValue = 'cmt';
                        }
                    } else if (strcasecmp ( $name, "epg" ) == 0) {
                        if ($dbnames->length){
                            $dbnames->item ( 0 )->nodeValue = 'epg';
                        }
                    }
                }
            }
        }

        $document->save ( $update_xml );
    }

    public function queryVersion() {
        // 文件路径
        $file = Consts::UPDATE_SRC . Consts::PROGRAM_CFG_FILE;

        $result = array ();
        if (file_exists ( $file )) {
            $xml = simplexml_load_file ( $file );
            // 更新包创建时间
            $createtime= $xml->xpath ( "createtime" );
            $node = array_shift ( $createtime );
            $create_time = date ( "Y-m-d", intval ( "" . $node ) );
            // 节目描述
           $desc= $xml->xpath ( "description" ) ;
            $desc = "" . array_shift ( $desc );

            $result ["create_time"] = $create_time;
            $result ["desc"] = $desc;
            $result ["code"] = Consts::CODE_SUCCESS;
        } else { // 文件不存在
          //  $result ["msg"] = Trans::t ( "文件不存在:" ) . $file;
            $result ["msg"] =  "文件不存在:"  . $file;
            $result ["code"] = Consts::CODE_FAILURE;
        }
        return $result;
    }

    public function start($target) {
        $target = Consts::TARGET_SERVER;
        $site = $this->_getSite ( $target );
        $param = array (
            "site" => $site,
            "item" => Consts::COPY_FROM_USB
        );
        return $this->_start ( Consts::CMD_START_PROG_UPDATE, $target, $param );
    }

    public function stop() {
        $result = CommandHelper::sendCommand ( Consts::CMD_COMPLETE_UPDATE, Consts::TARGET_SERVER );
        $result = $this->_parseStopResult ( $result );
        return $result;
    }

    protected function _parseStopResult($result) {
        switch ($result ["code"]) {
            case Consts::CODE_EXEC_SUCCESS :
                $result ["code"] = Consts::CODE_SUCCESS;
                break;

            case Consts::CODE_EXEC_FAILURE :
               // $result ["msg"] = Trans::t ( "发送结束更新命令失败！" );
                $result ["msg"] = "发送结束更新命令失败！";
                $result ["code"] = Consts::CODE_FAILURE;
                break;

            default :
                $result ["msg"] = CommandHelper::getErrorMsg ( $result ["code"] );
                SocketLog::log ("Unknown Error From( _parseStopResult())". $result ["code"]);
                $result ["code"] = Consts::CODE_FAILURE;
                break;
        }
        return $result;
    }

    public function queryProgress($target) {
        return $this->_queryProgress ( Consts::TARGET_SERVER, Consts::UPDATE_TYPE_PRG, "progressCallBack" );
    }

    public function progressCallBack($result) {
        if ($result ["code"] == Consts::CODE_FAILURE) {
            Log::write ( sprintf ( "*******program update failed for the reason: %s", $result ["reason"] ), Log::ERROR );
            $this->_logOperation ( sprintf ( "Program update failed for the reason: %s", $result ["reason"] ) );
        } else if ($result ["type"] == 4) {
           // $result ["msg"] = Trans::t ( "节目更新成功！" );
            $result ["msg"] =  "节目更新成功！" ;
            Log::write ( sprintf ( "*******program update success" ), Log::INFO );
            $this->_logOperation ( "Program update success" );
        } else {
            Log::write ( sprintf ( "*******program update progress: %s%%", $result ["progress"] ), Log::INFO );
        }
    }

    /**
     * 清除多余的媒体文件
     *
     * @see lib/Service/BaseUpdateService::cleanup()
     */
    public function cleanup() {
        set_time_limit ( 0 );
        // 根目录: /opt/lampp/htdocs/files
       // $base_dir = $_SERVER ["DOCUMENT_ROOT"] . '/files';

        $base_dir = '/opt/lampp/htdocs/files';
        $this->_logCleanup ( "base dir: $base_dir " );

        // 数据库名
        $dbname_epg = "epg";
        $dbname_cmt = "cmt";

        // 获取要清除的目录列表
        $dirty_dirs = $this->_getDirtyDirs ( $base_dir );
        $this->_logCleanup ( "dirty dir " . print_r ( $dirty_dirs, true ) );

        foreach ( $dirty_dirs as $dir ) {
            $this->_logCleanup ( "***********start clear movie file in $dir:" );
            // 清除电影
            $this->_cleanup ( $dir, "/video/movie", $dbname_epg . '.' . Consts::EPG_MOVIE_FILE, "filename", "url" );
            $this->_logCleanup ( "***********end clear movie file in $dir\r\n\r\n\r\n" );

            $this->_logCleanup ( "***********start clear tv file:" );
            // 清除电视
            $this->_cleanup ( $dir, "/video/tv", $dbname_epg . '.' . Consts::EPG_TV_FILE, "filename", "url" );
            $this->_logCleanup ( "***********end clear tv file in $dir\r\n\r\n\r\n" );

            $this->_logCleanup ( "***********start clear VA file in $dir:" );
            // 清除VA
            $this->_cleanup ( $dir, "/video/va", $dbname_cmt . '.' . Consts::CMT_VA, "filename", "url" );
            $this->_logCleanup ( "***********end clear VA file in $dir\r\n\r\n\r\n" );

            $this->_logCleanup ( "***********start clear PRAM file in $dir:" );
            // 清除PRAM
            $this->_cleanup ( $dir, "/audio/pram", $dbname_cmt . '.' . Consts::CMT_PRAM, "filename", "url" );
            $this->_logCleanup ( "***********end clear PRAM file in $dir\r\n\r\n\r\n" );

            $this->_logCleanup ( "***********start clear music file in $dir:" );
            // 清除音乐
            $this->_cleanup ( $dir, "/audio/music", $dbname_epg . '.' .Consts:: EPG_MUSIC, "file_name", "file_url" );
            $this->_logCleanup ( "***********end clear music file in $dir\r\n\r\n\r\n" );
        }

     //   $result ["msg"] = Trans::t ( "清理完成！节目更新结束！" );
        $result ["msg"] = "清理完成！节目更新结束！";
        $result ["code"] = Consts::CODE_SUCCESS;
        return $result;
    }

    private function _cleanup($base_dir, $sub_dir, $table_name, $col_name, $col_url) {
        // 文件路径
        $file_path = $base_dir . $sub_dir;

        if (is_file ( $file_path )) { // 如果是文件
            $this->_logCleanup ( "***********search file: $file_path \r\n" );
            $file_name = basename ( $file_path );
            $dir_name = dirname ( $sub_dir );
            // 判断文件是否存在数据库中
            $sql = sprintf ( "SELECT * FROM $table_name WHERE $col_name ='%s' AND REPLACE($col_url, '\\\\', '/')='%s' LIMIT 1", addslashes ( $file_name ), addslashes ( $dir_name ) );
            $this->_logCleanup ( "=== $sql" );
          //  $file_existed = DBHelper::getOne ( $sql );

            $file_existed = DB::select($sql);
            if (empty ( $file_existed )) { // 如果数据库不存在该记录，删除文件。
                $this->_removeFile ( $file_path );
            }
        } else if (is_dir ( $file_path )) { // 如果是文件夹，则递归遍历
            $this->_logCleanup ( "***********search directory: $file_path \r\n" );
            // 获取目录下所有文件
            $file_list = $this->_listFile ( $file_path );

            // 清理子目录中的文件
            foreach ( $file_list as $file ) {
                $sub_file_path = $sub_dir . Consts::DIRECTORY_SEPARATOR . $file;
                $this->_cleanup ( $base_dir, $sub_file_path, $table_name, $col_name, $col_url );
            }

            // 判断当前目录是为空，如果是则删除目录
            $file_list = $this->_listFile ( $file_path );
            if (empty ( $file_list )) {
                $this->_logCleanup ( "***********remove empty directory: $file_path \r\n" );
                $this->_removeFile ( $file_path );
            }
        }
    }

    private function _listFile($dir) {
        if (is_dir ( $dir )) {
            // 遍历文件夹
            $file_list = scandir ( $dir );

            // 删除当前目录
            $key = array_search ( ".", $file_list );
            if ($key !== false) {
                unset ( $file_list [$key] );
            }

            // 删除上层目录
            $key = array_search ( "..", $file_list );
            if ($key !== false) {
                unset ( $file_list [$key] );
            }
        }
        return $file_list;
    }

    private function _getDiskNumber() {
        $disk_num = 0;

        if (file_exists ( Consts::MEDIA_MULTI_DISKINFO_FILE )) {
            $xml = simplexml_load_file ( Consts::MEDIA_MULTI_DISKINFO_FILE );
            foreach ( $xml->children () as $node ) {
                if ($node->getName () == "disknum") {
                    // $node."" 将对象强制转换成字符串
                    $disk_num = intval ( $node . "" );
                    break;
                }
            }
        }
        return $disk_num;
    }

    private function _getDirtyDirs($base_dir) {
        // 读取外挂硬盘个数
        $disk_num = $this->_getDiskNumber ();

        $dirty_dirs = array ();
        if ($disk_num > 0) {
            // 构建要清除数据的目录列表： 根目录 + program + 外挂硬盘序号
            for($i = 0; $i < $disk_num; $i ++) {
                $dirty_dirs [] = $base_dir . Consts::DIRECTORY_SEPARATOR . "program" . $i;
            }
        } else {
            $dirty_dirs [] = $base_dir;
        }
        return $dirty_dirs;
    }

    private function _removeFile($file_path) {
        if (is_dir ( $file_path )) { // 删除目录
            $removed = rmdir ( $file_path );
            $this->_logCleanup ( "\tremove dir $file_path " . ($removed ? "success" : "failed") );
        } else if (is_file ( $file_path )) { // 删除文件
            $removed = unlink ( $file_path );
            $this->_logCleanup ( "\tremove file $file_path " . ($removed ? "success" : "failed") );
        }
    }

    private function _logCleanup($msg) {
        Log::write ( $msg, Log::DEBUG, Log::FILE, Log::LOG_PATH . "web_cleanup.log" );
    }
}
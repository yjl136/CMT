<?php

namespace App\Http\Service\Log;



use App\Http\Service\Consts;
use Illuminate\Support\Facades\Storage;

class Log{
    // 日志级别 从上到下，由高到低
   // const DATA_DIR='/usr/donica/update/data/';
    const DATA_DIR = '../storage/';
    const CRITICAL	= 6;	// 严重错误: 导致系统崩溃无法使用
    const ERROR		= 5;	// 一般错误: 一般性错误,SQL执行错误，网络包发送失败
    const WARNING	= 4;	// 警告性错误: 需要发出警告的错误
    const INFO		= 3;	// 信息: 程序输出信息,SQL语句
    const DEBUG		= 2;	// 调试: 调试信息
    const VERBOSE	= 1;	// 所有: 所有信息

    // 日志记录方式
    const SYSTEM    = 0;
    const MAIL      = 1;
    const FILE      = 3;
    const SAPI      = 4;
    const LOG_LEVEL = self::DEBUG;
    const LOG_TYPE = self::FILE;
    const LOG_PATH = self::DATA_DIR."logs/";
    const LOG_DEST = "web_cmt.log";
    const LOG_FILE_SIZE = 10485760;
    const LOG_EXTRA = '';


    // 日志信息
    static $log     =  array();

    // 日期格式
    static $format  =  '[ Y-m-d H:i:s ]';

    /**
     * 记录日志 并且会过滤未经设置的级别
     * @static
     * @access public
     * @param string $message 日志信息
     * @param string $level  日志级别
     * @param boolean $record  是否强制记录
     * @return void
     */
    static function record($message,$level=self::WARNING,$record=false) {
        if($record || $level >= self::LOG_LEVEL) {
            self::$log[] = "[".self::getLevel($level)."]: {$message}\r\n";
        }
    }

    /**
     * 日志保存
     * @static
     * @access public
     * @param integer $level 日志记录级别
     * @param integer $type 日志记录方式
     * @param string $destination  写入目标
     * @param string $extra 额外参数
     * @return void
     */
    static function save($level=self::WARNING,$type='',$destination='',$extra='') {
        if($level >= self::LOG_LEVEL){
            if(empty(self::$log)) return ;
            $type = $type?$type:self::LOG_TYPE;
            if(self::FILE == $type) { // 文件方式记录日志信息
                if(empty($destination))
                    $destination = self::LOG_PATH.self::LOG_DEST;
                //检测日志文件大小，超过配置大小则备份日志文件重新生成
                if(is_file($destination) && floor(self::LOG_FILE_SIZE) <= filesize($destination) ){
                    $new_filename = dirname($destination).'/'.date('Y_m_d_H_i_s',time()).'-'.basename($destination);
                    rename($destination,$new_filename);
                    unlink($new_filename);
                }
            }else{
                $destination   =   $destination?$destination:self::LOG_DEST;
                $extra   =  $extra?$extra:self::LOG_EXTRA;
            }
            $now = date(self::$format);
            error_log($now.' '.getonlineip().' '.$_SERVER['REQUEST_URI']."\r\n".implode('\r\n',self::$log)."\r\n", $type,$destination ,$extra);
            // 保存后清空日志缓存
            self::$log = array();
            //clearstatcache();
        }
    }

    /**
     * 日志直接写入
     * @static
     * @access public
     * @param string $message 日志信息
     * @param string $level  日志级别
     * @param integer $type 日志记录方式
     * @param string $destination  写入目标
     * @param string $extra 额外参数
     * @return void
     */
    static function write($message,$level=self::WARNING,$type=self::FILE,$destination='',$extra='') {
        if($level >= self::LOG_LEVEL){
            $now = date(self::$format);
            $type = $type?$type:self::LOG_TYPE;
            if(self::FILE == $type) { // 文件方式记录日志
                if(!file_exists(self::LOG_PATH)) {
                    if(!mkdir(self::LOG_PATH, 0777, true)){
                        return ;
                    }
                }
                if(empty($destination))
                    $destination = self::LOG_PATH.self::LOG_DEST;
                //检测日志文件大小，超过配置大小则备份日志文件重新生成
                if(is_file($destination) && floor(self::LOG_FILE_SIZE) <= filesize($destination) ){
                    $last_log = $destination.".last";
                    if(file_exists($last_log))
                        unlink($last_log);
                    rename($destination,$last_log);
                }
            }else{
                $destination   =   $destination?$destination:self::LOG_DEST;
                $extra   =  $extra?$extra:self::LOG_EXTRA;
            }
            error_log("{$now} [".self::getLevel($level)."]: {$message}\r\n", $type,$destination,$extra );
            //clearstatcache();
        }
    }

    /**
     * 日志直接写入
     * @static
     * @access private
     * @param string $level  日志级别
     * @return void
     */
    private static function getLevel($level){
        switch ($level){
            case self::CRITICAL:
                return "CRITICAL";

            case self::ERROR:
                return "ERROR";

            case self::WARNING:
                return "WARNING";

            case self::INFO:
                return "INFO";

            case self::DEBUG:
            default:
                return "DEBUG";
        }
    }
}
?>
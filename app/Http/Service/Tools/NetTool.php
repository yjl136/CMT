<?php
namespace App\Http\Service\Tools;
// route配置命令
define ( "COMMAND_ROUTE_ADD", "route add default gw %s" );
define ( "COMMAND_ROUTE_DEL", "route del default gw %s" );
define ( "COMMAND_ROUTE", "route" );

/**
 * 执行网络相关命令
 *
 * @author Luke Huang 2014-11-18
 *
 */
class NetTool {

    /**
     * 通过ping对方的IP检测网络连接状态
     * -c $count ping的次数
     * -i 0.201 每隔201ms发送一次ping指令
     * -w 总超时时间，默认60s
     *
     * @param $ip 终端IP地址
     * @param $timeout ping的总超时时间
     * @return 成功返回0，失败返回1
     */
    public function ping($ip, $timeout = 60) {
        $count = 3;
        system ( "ping -c $count -w $timeout -i 0.201 $ip 2>&1 >/dev/null", $error_code );
        return $error_code;
    }

    /**
     * 添加Route网关
     *
     * @param string $ip
     *        	路由网关的IP地址
     * @return int 命令执行结果代码
     */
    public function addRoute($ip) {
        $cmd = sprintf ( COMMAND_ROUTE_ADD, $ip );
        @exec ( $cmd, $output, $code );
        return $code;
    }

    /**
     * 删除Route网关
     *
     * @param string $ip
     *        	路由网关的IP地址
     * @return int 命令执行结果代码
     */
    public function delRoute($ip) {
        $cmd = sprintf ( COMMAND_ROUTE_DEL, $ip );
        @exec ( $cmd, $output, $code );
        return $code;
    }

    /**
     * 查询路由配置中是否包含该IP
     *
     * @param string $ip
     *        	路由网关的IP地址
     * @return boolean 是否包含
     */
    public function route($ip) {
        $last_line = @exec ( COMMAND_ROUTE, $output, $code );
        return ! (strpos ( $last_line, $ip ) === FALSE);
    }
}
?>
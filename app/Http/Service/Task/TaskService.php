<?php
namespace App\Http\Service\Task;

use App\Http\Service\Base\BaseService;

class TaskService extends BaseService {

    /**
     * 获取指定任务类型对应的任务模板
     *
     * @param string $task_type
     */
    public function getTask($task_type) {
        $sql = "SELECT * FROM " . CMT_TASK . " WHERE Active = '1' AND TaskDesc = '$task_type' ORDER BY TaskID Limit 1";
        return DBHelper::getOne ( $sql );
    }

    /**
     * 获取指定ID对应的任务模板
     *
     * @param integer $task_id
     *        	任务ID
     */
    public function getTaskByID($task_id) {
        $sql = "SELECT * FROM " . CMT_TASK . " WHERE Active = '1' AND TaskID = '$task_id' ORDER BY TaskID Limit 1";
        return DBHelper::getOne ( $sql );
    }

    /**
     * 获取所有可处理的任务模板
     *
     * @return array 任务模板列表
     */
    public function getTaskList() {
        $sql = "SELECT * FROM " . CMT_TASK . " WHERE Active = '1' ORDER BY TaskID";
        return DBHelper::getList ( $sql );
    }

    /**
     * 查询指定任务类型的所有任务实例
     *
     * @param integer $task_id
     *        	任务ID
     * @param string $current_time
     *        	当前时间(用于判断是否历史任务)
     * @param boolean $flag_current
     *        	是否当前任务
     * @return array 任务实例列表
     */
    public function getTaskInstanceList($task_id, $current_time, $flag_current) {
        if ($flag_current) {
            $sql = "SELECT * FROM " . CMT_TASK_INSTANCE . " WHERE EndTime > '$current_time' AND TaskMode = '" . TASK_MODE_AUTO . "' AND TaskID = '$task_id' ORDER BY ID DESC";
        } else {
            $sql = "SELECT * FROM " . CMT_TASK_INSTANCE . " WHERE EndTime <= '$current_time' AND TaskID = '$task_id' AND Status in (" . TASK_STATUS_INIT . "," . TASK_STATUS_EXEC_FAIL . ") ORDER BY ID DESC";
        }
        return DBHelper::getList ( $sql );
    }

    /**
     * 查询未完成或者发送失败的自动导出任务
     *
     * @return array 任务实例列表
     */
    public function getUncompleteTaskInstanceList() {
        $sql = "SELECT * FROM " . CMT_TASK_INSTANCE . " WHERE Status in ('" . TASK_STATUS_INIT . "', '" . TASK_STATUS_SEND_FAIL . "') AND TaskMode = '" . TASK_MODE_AUTO . "' ORDER BY Status";
        return DBHelper::getList ( $sql );
    }

    /**
     * 获取指定ID对应的任务实例
     *
     * @param integer $task_instance_id
     */
    public function getTaskInstance($task_instance_id) {
        $sql = "SELECT * FROM " . CMT_TASK_INSTANCE . " WHERE ID = '$task_instance_id' LIMIT 1";
        return DBHelper::getOne ( $sql );
    }

    public function saveTaskInstance($data) {
        return DBHelper::save ( CMT_TASK_INSTANCE, $data );
    }

    /**
     * 根据任务实例ID，更新数据内容
     *
     * @param integer $task_instance_id
     *        	任务实例ID
     * @param array $params
     *        	数据列表
     */
    public function updateTaskInstance($task_instance_id, $params) {
        $data = array ();
        array_push($data, sprintf("FinishTime = '%s'", date("Y-m-d H:i:s", time())));

        $avail_columns = array (
            "Status",
            "Descs",
            "FilePath",
            "MailDataID"
        );
        foreach ( $params as $key => $value ) {
            if (in_array ( $key, $avail_columns )) {
                array_push ( $data, sprintf ( " $key = '$value' " ) );
            }
        }
        $sql = "UPDATE " . CMT_TASK_INSTANCE . " SET " . implode ( ',', $data ) . " WHERE ID = '$task_instance_id'";
        return DBHelper::saveOrUpdate ( $sql );
    }

    /**
     * 获取对应的星期英文，便于使用strtotime("next ".$weekday)获取下一个星期的时间
     *
     * @param integer $weekday
     *        	星期
     * @return string 星期几(英文)
     */
    public function getWeekday($weekday) {
        switch ($weekday) {
            case WEEKDAY_MON :
                $weekdayStr = "Monday";
                break;

            case WEEKDAY_TUES :
                $weekdayStr = "Tuesday";
                break;

            case WEEKDAY_WED :
                $weekdayStr = "Wednesday";
                break;

            case WEEKDAY_THUR :
                $weekdayStr = "Thursday";
                break;

            case WEEKDAY_FRI :
                $weekdayStr = "Friday";
                break;

            case WEEKDAY_SAT :
                $weekdayStr = "Saturday";
                break;

            case WEEKDAY_SUN :
                $weekdayStr = "Sunday";
                break;

            default :
                $weekdayStr = "day";
                break;
        }

        return $weekdayStr;
    }
}
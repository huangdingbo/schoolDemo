<?php


namespace console\controllers;


use console\lib\WriteLogTool;
use console\models\TaskLogModel;
use console\models\TaskModel;
use console\models\ToolModel;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Class CommonController
 * @package console\controllers
 * 公告的控制器类，不继承该类将无法判断任务是否执行成功
 * 无法添加日志记录
 */
class CommonController extends Controller
{
    public $task;
    public $log;

    public function beforeAction($action)
    {
        try{
            if (parent::beforeAction($action)){
                $program =$action -> getUniqueId();
                $task = TaskModel::findOne(['program'=>$program]);
                if(!$task){
                    throw new Exception("Can not find ".$program." in console tasks. Please check it.");
                }
                $this->task = $task;
                //执行任务前的初始化
                $this->taskInit();
                //记录执行日志
                $this->log = new TaskLogModel();
                $this->log->task_id = $this->task->id;
                $this->log->start_time = date("Y-m-d H:i:s");
                $this->log("Task [".$task->program."] started.");
            }
        }catch (\Exception $e){
            WriteLogTool::writeLog($e->getMessage(),$program);exit;
        }
        return true;
    }

    public function afterAction($action, $result)
    {
        if (parent::afterAction($action, $result)){
            $this->task->last_finish_time = date("Y-m-d H:i:s",time());
            if(!$result){
                //改状态
                $this->task->status=TaskModel::RUNNING_FAILED;

                $this->task->is_kill = TaskModel::TASK_IS_KILLED;
            }else{
                $this->task->status=TaskModel::RUNNING_SUCCESS;
            }
            //任务执行时间
            $this->task->run_time = strtotime($this->task->last_finish_time) - strtotime($this->task->last_start_time);
            $this->task->save(false);
            $this->log->finish_time = $this->task->last_finish_time;
            $this->log("Task [".$this->task->program."] finished.");
            $this->log->save(false);
        }
        return true;
    }

    public function log($str)
    {
        $this->log->info.="\n ".date('Y-m-d H:i:s')."---->".$str;
    }

    /**
     * @param $task
     * 执行任务前的初始化操作
     */
    public function taskInit(){
        try{
            $this->task->status = TaskModel::RUNNING;
            $this->task->last_start_time = date('Y-m-d H:i:s',time());
            if ($this->task->type == TaskModel::RUN_INTERVAL){
                $this->task->next_start_time = date('Y-m-d H:i:s',(strtotime($this->task->last_start_time) + $this->task->info));
            }
            if ($this->task->type == TaskModel::RUN_FIXED_TIME){
                $nowDay = date('Y-m-d',time());
                $nextDay = date('Y-m-d',strtotime("$nowDay +1 day"));
                $this->task->next_start_time = $nextDay .' '. $this->task->info;
            }
            $this->task -> save(false);
        }catch (\Exception $e){
            WriteLogTool::writeLog($e->getMessage());exit;
        }
        return true;
    }
}
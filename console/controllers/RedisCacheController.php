<?php


namespace console\controllers;


use common\components\RbacCheck;
use console\lib\ConsoleBaseController;
use console\lib\WriteLogTool;
use frontend\models\Adminuser;

class RedisCacheController extends ConsoleBaseController
{
    public function actionUpdate(){

        try{
            //adminuser表所有用户
            $adminuserList = Adminuser::find()->select('id')->asArray()->all();

            foreach ($adminuserList as $item){
                RbacCheck::getAuthList($item['id'],'1');
            }
        }catch (\Exception $e){
            WriteLogTool::writeLog($e->getMessage(),$this->action->getUniqueId());
        }
        return true;
    }
}
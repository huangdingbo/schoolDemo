<?php


namespace console\controllers;


use common\components\RbacCheck;
use frontend\models\Adminuser;
use yii\console\Controller;
use yii\helpers\Console;

class RedisCacheController extends Controller
{
    public function actionUpdate(){

        try{
            //adminuser表所有用户
            $adminuserList = Adminuser::find()->select('id')->asArray()->all();

            foreach ($adminuserList as $item){
                RbacCheck::getAuthList($item['id'],'1');
            }
        }catch (\Exception $e){
            var_dump($e);exit;
        }

        return true;
    }
}
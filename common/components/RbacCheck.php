<?php


namespace common\components;


use frontend\models\RbacAssignment;
use frontend\models\RbacItemChild;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

class RbacCheck
{
    public static function run($uniqeId){
        $userId = \Yii::$app->user->id;

        $authList = self::getAuthList($userId);

        if (!in_array($uniqeId,$authList)){
           return false;
        }

        return true;
    }

    public static function getAuthList($userId,$isUpdate = '0'){
        $redisCacheKey = 'user'.$userId;

        if ($isUpdate == '1'){

            $cache = Yii::$app->cache;

            if ($cache->exists($redisCacheKey)){

                $cache->delete($redisCacheKey);
            }
        }

        $res = RedisCache::run($redisCacheKey,function () use ($userId){
            $authList = array();

            $assignmentList = RbacAssignment::find()->where(['user_id' => $userId])->asArray()->all();

            foreach ($assignmentList as $item){

                $list = RbacItemChild::find()->where(['parent' => $item['item_name']])->asArray()->all();

                $authList = array_merge(ArrayHelper::getColumn($list,'child'),$authList);
            }

            return $authList;

        },1*24*60*60);

        return $res;
    }
}
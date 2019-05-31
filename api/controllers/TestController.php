<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/28
 * Time: 14:14
 */

namespace api\controllers;


use common\components\RedisCache;
use common\components\RegularExpression;
use frontend\controllers\StudentController;
use frontend\models\Student;
use frontend\models\Warning;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class TestController extends Controller
{
    /**
     * @return array
     * 测试redis
     */
    public function actionIndex(){

//        var_dump(\Yii::$app->request->get()['r']);exit;
//        $list = Warning::find()->asArray()->all();
//
//        return ['list' => $list];

        $list = RedisCache::run($this->action->getUniqueId().'3',function (){

            $list = Warning::find()->asArray()->all();

            sleep(10);

            return $list;

        });



        return ['list'=>$list];

//        $cache = Yii::$app->cache;
//
//        $cacheData = $cache->get($this->action->getUniqueId());
//        if ($cacheData){
//            echo 111;
//            return ['list' => $cacheData];
//        }else{
//            $list = Warning::find()->asArray()->all();
//
//            sleep(10);
//
//            $cache->set($this->action->getUniqueId(),$list,'3600');
//
//            echo 222;
//            return  ['list' => $list];
//        }
//        //定义key
//
//
//
//        var_dump($list);exit;
//        var_dump($this->action->getUniqueId());
//
//        exit;

        //redis缓存


//        if ($cache->get('username')){
//            echo 111;
//            var_dump($cache->get('username'));exit;
//        }else{
//            $cache->set('username','123');
//            echo  222;
//            var_dump($cache->get('username'));exit;
//        }

//        return [
//            'list' => $list
//        ];
    }

    public function actionRegular()
    {
        /**
         * 匹配以数字开头，并以 abc 结尾的字符串。：
         *str = "123abc";
         */
        $str = "Is is the cost of of gasoline going up up?";

        $patter = '/(?=.*)/';

       $res = RegularExpression::match($patter,$str);

        var_dump($res);exit;
        echo 111;exit;
    }

    /**
     * @return int
     * @throws ForbiddenHttpException
     * 获取数据库第几条数据的id
     */
    public function actionMiddle(){

        $num = \Yii::$app->request->get('num');

        if (!$num){
            throw new ForbiddenHttpException('请传要获取数据库第几条数据!');
        }

       return $this->getNumId($num);
    }

    /**
     * @param $num
     * @return int
     * 获取id
     */
    private function getNumId($num){
        //查询最小的id
        $minId = Student::find()->select('min(id) as minId')->asArray()->one()['minId'];

        //假设id连续
        $resId = $minId + $num;

        //判断是否有50条
        $id = $this->check($resId,$num);

        return $id;
    }

    /***
     * @param $id
     * @param $num
     * @return int
     * 递归检查
     */
    private function check($id,$num){

        $total = Student::find()->select('count(*) as num')->where(['<','id',$id])->asArray()->one()['num'];

        if ($total < $num){

            $id += 1;

            $this->check($id,$num);
        }

        return $id;
    }



    public function actionError(){
        try{
            new my();
        }catch (Exception $e){
            echo 111;
            var_dump($e->getMessage());exit;
        }



    }























}
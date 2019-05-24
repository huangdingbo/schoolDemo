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
use frontend\models\Warning;
use yii\web\Controller;

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

    public function actionH(){
        echo 11;
        print_r(get_class_methods(new StudentController('','','')));exit;
    }

}
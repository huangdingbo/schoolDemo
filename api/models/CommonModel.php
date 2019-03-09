<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/7
 * Time: 22:27
 */

namespace api\models;


use frontend\models\Test;
use yii\base\Model;

class CommonModel extends Model
{
    public static function getNewTest(){
        $newTest = Test::find()->select('test_num')
            ->orderBy('insert_time desc,grade_num asc')
            ->asArray()
            ->one();
        return $newTest;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/18
 * Time: 19:08
 */

namespace api\models;


use frontend\models\Class0;
use frontend\models\Grade;
use frontend\models\Score;
use frontend\models\Test;
use frontend\models\Warning;
use frontend\models\Wire;
use yii\base\Model;

class WarningIndexModel extends  Model
{
    public static function getWarningNum($testNum,$type,$studentType,$grade,$class){
        $query = Warning::find()->leftJoin('score','score.id = warning.score_id')
            ->where(['score.type' => $studentType,'score.grade' => $grade]);
        if ($type){
            $query -> andWhere(['warning.type' => $type]);
        }
        $newQuery = clone $query;
        if ($testNum){
            $query -> andWhere(['warning.warning_test' => $testNum]);
        }

        if ($class){
            $query -> andWhere(['score.banji' => $class]);
        }
        //当前预警
        $currentNum = $query->andWhere(['warning.status' => 1])->count();
        //预警总数
        $totalNum = $newQuery->count();
        //预警/次
        if (!$testNum){
            $kaoshiNum = Test::find()->where(['type'=>$studentType,'grade_num' => self::$config[$grade]])->count();
            $avg = (string)round($totalNum/$kaoshiNum,'0');
        }
        return [
            'currentNum' => $currentNum,
            'totalNum' => $totalNum,
            'avg' => isset($avg) ? $avg : '',
        ];
    }

    private static $config = [
        '2019届' => '1',
        '2018届' => '2',
        '2017届' => '3',
    ];

    public static function getGradeList(){
        $list = Grade::find()->select('the as name')->orderBy('id asc')->asArray()->all();
        foreach ($list as &$aitem){
            $aitem['value'] = $aitem['name'].'届';
            $aitem['name'] = $aitem['value'];
        }

        return $list;
    }

    public static function getClassList(){
        $list = Class0::find()->select('name')->orderBy('id asc')->asArray()->all();
        foreach ($list as &$aitem){
            $aitem['value'] = $aitem['name'];
        }

        return $list;
    }
}
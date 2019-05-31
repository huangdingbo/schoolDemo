<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/16
 * Time: 19:13
 */

namespace api\controllers;


use api\models\ClassAnalysisModel;
use frontend\models\Score;
use frontend\models\Test;
use frontend\models\Warning;
use yii\web\ForbiddenHttpException;

class ClassAnalysisController extends  MyController
{

    /**
     * @return array
     * 学生构成分析
     */
    public function actionConstitute(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }
        //获取列表
        $list = ClassAnalysisModel::getStudentConstituteForClass($testNum,$type);
        return [
            'list' => $list
        ];
    }

    public function actionAvgRank(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        if (!$type){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = ClassAnalysisModel::getAvgRankForClass($testNum,$type);

        return [
            'list' => $list
        ];
    }

    public function actionHistoryAvgRank(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }

        $list = ClassAnalysisModel::getHistoryAvgRankForClass($testNum);

        return [
            'list' => $list
        ];
    }

    public function actionStable(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }
        $testModel = Test::findOne(['test_num' => $testNum]);
        $grade = $testModel->grade_num;
        $testType = $testModel->type;

        $list = ClassAnalysisModel::getStableForClass($grade,$testType);

        return [
            'list' => $list
        ];
    }

    /**
     *本次考试各班预警人数
     */
    public function actionWarningNum(){
        $postData = \Yii::$app->request->post();
        $testNum =  isset($postData['testNum']) ? $postData['testNum'] : '';
        if (!$testNum){
            throw new ForbiddenHttpException('缺少考试编号');
        }

        $list = Warning::find()->leftJoin('score','warning.score_id = score.id')
            ->select('score.banji as name,count(*) as value')
            ->where(['warning.warning_test' => $testNum])
            ->groupBy('score.banji')
            ->orderBy('value desc')
            ->asArray()
            ->all();

        return ['list' => $list];

    }

}
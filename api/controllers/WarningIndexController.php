<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/3/18
 * Time: 19:06
 */

namespace api\controllers;


use api\models\WarningIndexModel;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class WarningIndexController extends MyController
{
    public function actionHeader(){
        $postData = \Yii::$app->request->post();
        $grade =  isset($postData['grade']) ? $postData['grade'] : '';
        $studentType = isset($postData['studentType']) ? $postData['studentType'] : '';
        $testNum = isset($postData['testNum']) ? $postData['testNum'] : '';
        $type = isset($postData['type']) ? $postData['type'] : '';
        $class = isset($postData['class']) ? $postData['class'] : '';
        if (!$grade){
            throw new ForbiddenHttpException('缺少年级');
        }
        if (!$studentType){
            throw new ForbiddenHttpException('缺少类型,1理科2文科');
        }

        $list = WarningIndexModel::getWarningNum($testNum,$type,$studentType,$grade,$class);

        return [
            'list' => $list
        ];
    }

    public function actionGradeList(){
        $list = WarningIndexModel::getGradeList();

        return [
            'list' => $list
        ];
    }

    public function actionClassList(){
        $list = WarningIndexModel::getClassList();

        return [
            'list' => $list
        ];
    }
}
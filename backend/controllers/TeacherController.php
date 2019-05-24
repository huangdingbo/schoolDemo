<?php


namespace backend\controllers;


use backend\models\GeneralName;
use frontend\models\Teacher;
use yii\web\Controller;

class TeacherController extends Controller
{
    public function actionIndex(){
        $list = Teacher::find()->asArray()->all();

        foreach ($list as $item){
            \Yii::$app->db->createCommand()->update('teacher',[
                'name' => (new GeneralName())->getName(),
                'pic' => 'http://huangdingbo.work/school/frontend/web/upload/teacher.png',
                ],['id' => $item['id']])->execute();
        }

        echo 'ok';exit;
    }
}
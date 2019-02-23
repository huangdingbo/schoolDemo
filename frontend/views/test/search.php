<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/2/18
 * Time: 17:15
 */

use kartik\select2\Select2;
use yii\web\JsExpression;

\yii\bootstrap\ActiveForm::begin();
$data = \frontend\models\Teacher::find()->select('name,teacher_id')->indexBy('teacher_id')->column();
echo Select2::widget([
    'name' => 'title',
    'data' => $data,
    'options' => ['placeholder' => '请选择...']
]);

\yii\bootstrap\ActiveForm::end();
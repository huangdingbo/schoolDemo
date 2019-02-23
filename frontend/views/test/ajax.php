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
echo $form->field($model, 'title')->widget(Select2::classname(), [
    'options' => ['placeholder' => '请输入标题名称 ...'],
    'pluginOptions' => [
        'placeholder' => 'search ...',
        'allowClear' => true,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting...'; }"),
        ],
        'ajax' => [
            'url' => 'http://huangdingbo.work/school/frontend/web/index.php?r=test/data&q=1',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(res) { return res.text; }'),
        'templateSelection' => new JsExpression('function (res) { return res.text; }'),
    ],
]);
\yii\bootstrap\ActiveForm::end();
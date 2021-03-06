<?php
$this->title = '上传毕业相关文档';
$this->params['breadcrumbs'][] = $this->title;

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'uploader')->fileInput();

echo $form->field($model,'tocken')->passwordInput();

echo $form->field($model,'capt')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'site/captcha',
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>'
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
<?php
$this->title = '下载毕业相关文档';
$this->params['breadcrumbs'][] = $this->title;

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'fileName')->dropDownList($files);

echo $form->field($model,'tocken')->passwordInput();

echo $form->field($model,'capt')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'site/captcha',
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>'
]);
echo \yii\bootstrap\Html::submitButton('下载',['class'=>'btn btn-success']);
echo "&nbsp&nbsp&nbsp&nbsp";
echo \yii\helpers\Html::a('去上传',\yii\helpers\Url::to(['document/upload']),['class' => 'btn btn-warning']);
\yii\bootstrap\ActiveForm::end();


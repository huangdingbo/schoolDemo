<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \frontend\models\TaskToolModel;


/* @var $this yii\web\View */
/* @var $model frontend\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'program')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type') ->dropDownList(TaskToolModel::$types,['prompt'=>'请选择任务类型']); ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true])->label('任务信息(间隔执行填写秒数，一次执行不填，指定时间执行填H:i:s)') ?>

    <?= $form->field($model, 'start_time')->widget(datetimepicker::classname(), [
        'options' => ['placeholder' => '请选择任务开始时间'],
        'pluginOptions' => [
//            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:00',
            'todayHighlight' => true
        ]
    ]); ?>

    <?= $form->field($model, 'timeOut')->textInput(['maxlength' => true])->label('执行超时时间(单位秒)') ?>

    <div class="form-group">
        <?= Html::submitButton('创建', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

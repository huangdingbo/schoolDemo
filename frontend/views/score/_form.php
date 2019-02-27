<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Score */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="score-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cand_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'banji')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chinese')->textInput() ?>

    <?= $form->field($model, 'math')->textInput() ?>

    <?= $form->field($model, 'english')->textInput() ?>

    <?= $form->field($model, 'physics')->textInput() ?>

    <?= $form->field($model, 'chemistry')->textInput() ?>

    <?= $form->field($model, 'biology')->textInput() ?>

    <?= $form->field($model, 'politics')->textInput() ?>

    <?= $form->field($model, 'history')->textInput() ?>

    <?= $form->field($model, 'geography')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'class_rank')->textInput() ?>

    <?= $form->field($model, 'school_rank')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'insert_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
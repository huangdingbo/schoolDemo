<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RbacItem */
/* @var $routeList */

$this->title = '分配路由:'.$model->parent;
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-item-rule">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'child')->widget(Select2::classname(), [
        'data' => $routeList,
        'options' => ['multiple' => true, 'placeholder' => '请选择 ...'],
    ])->label('选择路由（多选）') ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RbacItem */
/* @var $routeList */
/* @var $defaultRoutes */

$this->title = '分配路由:'.$model->parent;
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($routeList);exit;
?>
<div class="rbac-item-rule">

    <?=Html::beginForm()?>
    <?= Select2::widget([
        'name' => 'child',
        'value' => $defaultRoutes,
        'data' => $routeList,
        'options' => ['multiple' => true,'placeholder' => '请选择...']
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?=Html::endForm()?>
<!--    --><?php //ActiveForm::end(); ?>

</div>
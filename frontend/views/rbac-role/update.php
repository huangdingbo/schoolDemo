<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RbacItem */

$this->title = '修改路由: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '路由管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

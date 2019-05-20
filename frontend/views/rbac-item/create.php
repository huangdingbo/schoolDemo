<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RbacItem */

$this->title = '添加路由';
$this->params['breadcrumbs'][] = ['label' => '路由管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

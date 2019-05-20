<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RbacItem */

$this->title = '添加角色';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

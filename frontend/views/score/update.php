<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Score */

$this->title = 'Update Score: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="score-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
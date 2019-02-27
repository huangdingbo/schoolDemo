<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Score */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="score-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cand_id',
            'student_id',
            'name',
            'test_name',
            'grade',
            'banji',
            'chinese',
            'math',
            'english',
            'physics',
            'chemistry',
            'biology',
            'politics',
            'history',
            'geography',
            'total',
            'class_rank',
            'school_rank',
            'type',
            'insert_time',
            'update_time',
        ],
    ]) ?>

</div>
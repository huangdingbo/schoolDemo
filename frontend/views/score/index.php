<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ScoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Score', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cand_id',
            'student_id',
            'name',
            'test_name',
            //'grade',
            //'banji',
            //'chinese',
            //'math',
            //'english',
            //'physics',
            //'chemistry',
            //'biology',
            //'politics',
            //'history',
            //'geography',
            //'total',
            //'class_rank',
            //'school_rank',
            //'type',
            //'insert_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
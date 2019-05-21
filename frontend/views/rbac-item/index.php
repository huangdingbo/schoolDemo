<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RbacItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '路由管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="rbac-item-index">

    <p>
        <?= Html::a('添加路由', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'description',
            [
                    'attribute' => 'rule_id',
                    'value' => function($dataProvider){
                        return (\frontend\models\RbacRule::find(['item_id' => $dataProvider->id])->orderBy('updated_at desc')->one())['name'];
                    }
            ],
            [
                'attribute' => 'data',
                'value' => function($dataProvider){
                    return (\frontend\models\RbacRule::find(['item_id' => $dataProvider->id])->orderBy('updated_at desc')->one())['data'];
                }
            ],
            [
                    'attribute' => 'created_at',
                    'format' => ['date','Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date','Y-m-d H:i:s'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{rule}{delete}',
                'buttons' => [
                    'rule' => function ($url, $model, $key) {
                        return Html::a('<span class = "glyphicon glyphicon-saved"></span>&nbsp;&nbsp;', $url, [
                            'title' => Yii::t('yii','增加规则'),
                            'aria-label' => Yii::t('yii','增加规则'),
                            'data-id' => $key,
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

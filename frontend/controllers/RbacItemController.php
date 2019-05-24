<?php

namespace frontend\controllers;

use common\components\RbacCheck;
use frontend\models\RbacRule;
use Yii;
use frontend\models\RbacItem;
use frontend\models\RbacItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RbacItemController implements the CRUD actions for RbacItem model.
 */
class RbacItemController extends CommonController
{
    protected $rbacNeedCheckActions = ['create','update','delete','rule'];

    protected $mustlogin = ['create','update','delete','rule','index','view'];
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * Lists all RbacItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RbacItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RbacItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RbacItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RbacItem();

        $model->type = '2';

        if ($model->load(Yii::$app->request->post())) {
            $name = RbacItem::findOne(['name' => $model->name]);
            if ($name){
                Yii::$app->session->setFlash('warning',$name->name.'已经存在!!!');
                return $this->redirect(['index','is_rout' => '1']);
            }
            if ($model->save()){
                return $this->redirect(['index','is_rout' => '1']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RbacItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','is_rout' => '1']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RbacItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index','is_rout' => '1']);
    }

    /**
     * Finds the RbacItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RbacItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RbacItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRule($id){
        $model = new RbacRule();

        $model -> item_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['index','is_rout' => '1']);
        }

        return $this->render('rule',['model' => $model]);
    }


}

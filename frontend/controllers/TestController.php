<?php

namespace frontend\controllers;

use frontend\models\Kaohao;
use frontend\models\TestForm;
use Yii;
use frontend\models\Test;
use frontend\models\TestSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
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
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Test();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCandidate($id){
        $testInfo = Test::findOne(['id'=>$id]);

        $model = new TestForm();

        $postData = Yii::$app->request->post();


        if ($model->load($postData) && $model->validate()){
            Kaohao::deleteAll(['test_num'=>$testInfo->test_num]);

//            if (Kaohao::find()->where(['test_num'=>$testInfo->test_num])->count()){
//                Yii::$app->session->setFlash('warning','本次考号已存在，请勿重复操作');
//                return $this->redirect(['kaohao/index']);
//            }
            $modelTest = new Test();
            if ($modelTest->test_num == 0){
                $list = $modelTest->getCandData($testInfo);
               if ($modelTest->insertCandData($list)){

                   Yii::$app->session->setFlash('success','考号生成成功');
                   return $this->redirect(['kaohao/index']);
               }
            }
        }

      return $this->render('cnad',[
          'model' => $model
      ]);

    }

    public function actionAudit($id){
        $model = Test::find()->where(['id' => $id])->one();
        $model->status = 2;
        if (!$model->save()){
            throw new ForbiddenHttpException('操作失败，原因未知');
        }
       return $this->redirect(['index']);
    }

}
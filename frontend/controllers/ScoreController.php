<?php

namespace frontend\controllers;

use frontend\models\Student;
use Yii;
use frontend\models\Score;
use frontend\models\ScoreSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScoreController implements the CRUD actions for Score model.
 */
class ScoreController extends Controller
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
     * Lists all Score models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $searchModel->type,

        ]);
    }

    /**
     * Displays a single Score model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $img = (Student::find()->where(['student_id'=>$model->student_id])->one())->pic;

        $model->img = $img;
        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Score model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id = Yii::$app->request->get('id');
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $per_page = 15;
        //接收成绩
        $list = Yii::$app->request->post();
        //更新成绩表
        $model = new Score();
        $model->insertScoreData($list);
        //更新总分、校名、班名
        $testNum = Yii::$app->request->get('test_num');
        $model->calculateRank($testNum);

        $url = Url::to(['test/entry','id'=>$id,'page'=>$page,'per-page'=>$per_page]);
        Yii::$app->session->setFlash('success','成绩插入成功！');
        return $this->redirect($url);
    }

    /**
     * Updates an existing Score model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $img = (Student::find()->where(['student_id'=>$model->student_id])->one())->pic;

        $model->img = $img;

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Score model.
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
     * Finds the Score model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Score the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Score::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function beforeAction($action) {

        $currentaction = $action->id;

        $novalidactions = ['create'];

        if(in_array($currentaction,$novalidactions)) {

            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);

        return true;
    }


}
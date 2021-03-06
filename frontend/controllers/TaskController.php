<?php

namespace frontend\controllers;

use console\lib\WriteLogTool;
use console\models\TaskModel;
use console\models\ToolModel;
use frontend\models\TaskLog;
use Yii;
use frontend\models\Task;
use frontend\models\TaskSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends FrontendController
{
    /**
     * @inheritdoc
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $getData = Yii::$app->request->get();
//        $isRestart = isset($getData['restart']) ? $getData['restart'] : '';
//        if ($isRestart == '1'){
//            $model = new Task();
//            if (!$model->killTask('main/index')){
//                Yii::$app->session->setFlash('danger','主进程重启失败！！！');
//            }else{
//                Yii::$app->session->setFlash('success','操作成功，主进程将在三分钟以后启动！！！');
//            }
//        }
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $mainProcessId = $searchModel->getMainProcessId();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mainProcessId' => $mainProcessId,
            'todayLog' => WriteLogTool::outputLog(),
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
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

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
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
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLog($id){

        $taskModel = $this->findModel($id);

        return $this->renderAjax('log',['model' => $taskModel]);
    }

    public function actionToday(){

        $todayLog = ToolModel::outputLog();

        return $this->renderAjax('today',['todayLog' => $todayLog]);
    }

    public function actionClean(){
        $file = \Yii::getAlias('@console') . '/runtime/' .date('Ymd') . '/'.'taskLog.txt';

        if (file_exists($file)){
            file_put_contents($file,'');
        }

        TaskLog::deleteAll();

        Yii::$app->session->setFlash('success','日志清除成功!!!');
        return $this->redirect(['index']);
    }

}

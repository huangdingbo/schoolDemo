<?php


namespace frontend\controllers;


use frontend\models\RbacItem;
use frontend\models\RbacItemChild;
use frontend\models\RbacItemSearch;
use frontend\models\RbacRule;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacRoleController extends CommonController
{
    protected $rbacNeedCheckActions = ['create','update','item','delete'];

    protected $mustlogin = ['create','update','item','delete','index'];
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
     * Creates a new RbacItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RbacItem();

        $model->type = '1';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
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
            return $this->redirect(['index']);
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

        return $this->redirect(['index']);
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

    public function actionItem($id){
        $model = new RbacItemChild();

        $model->parent = (RbacItem::findOne(['id' => $id]))['name'];

        $routeList = RbacItem::find()->select('description,name')->where(['type' => '2'])->indexBy('name')->asArray()->column();

        if (Yii::$app->request->isPost){
            $routes = Yii::$app->request->post();

            foreach ($routes['RbacItemChild']['child'] as $route){
                $insetModel = clone $model;

                $insetModel->child = $route;

                if ($insetModel->save()){
                    continue;
                }else{
                    Yii::$app->session->setFlash('danger','路由分配失败！！！');
                    $this->redirect(['index']);
                }
            }
            Yii::$app->session->setFlash('success','路由分配成功！！！');
            $this->redirect(['index']);
        }
        return $this->render('item',[
            'model' => $model,
            'routeList' => $routeList,
        ]);
    }
}
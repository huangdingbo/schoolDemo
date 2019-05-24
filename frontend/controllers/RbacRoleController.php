<?php


namespace frontend\controllers;


use frontend\models\Adminuser;
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
//    protected $rbacNeedCheckActions = ['create','update','item','delete'];

    protected $mustlogin = ['create','update','item','delete','index'];


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

        $adminguserInfo = RbacItem::findOne(['id' => $id]);

        $defaultRoutes = RbacItemChild::find()->select('child')->where(['parent' => $adminguserInfo->name])->asArray()->column();


        if (Yii::$app->request->isPost){

            $routes = Yii::$app->request->post();

           $psotRoutesNum = count($routes['child']);

           $defaultRoutesNum = count($defaultRoutes);

            //如果没有变化，跳转到首页
           if ($psotRoutesNum == $defaultRoutesNum){
              return $this->redirect(['index']);
           }

           //删除所有权限，重新分配
            RbacItemChild::deleteAll(['parent' => $adminguserInfo->name]);

            foreach ($routes['child'] as $route){
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
            return $this->redirect(['index']);
        }
        return $this->render('item',[
            'model' => $model,
            'routeList' => $routeList,
            'defaultRoutes' => $defaultRoutes
        ]);
    }
}
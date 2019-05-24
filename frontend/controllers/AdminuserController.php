<?php

namespace frontend\controllers;

use common\components\RbacCheck;
use frontend\models\AuthAssignment;
use frontend\models\AuthItem;
use frontend\models\Adminuser;
use frontend\models\AdminuserSearch;
use frontend\models\RbacAssignment;
use frontend\models\RbacItem;
use frontend\models\ResetpwdForm;
use frontend\models\SignupForm;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends CommonController
{
    protected $rbacNeedCheckActions = ['create','update','resetpwd','delete','privilege'];

    protected $mustlogin = ['index','view','create','update','resetpwd','delete','privilege'];
    /**
     * @inheritdoc
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
//
//
//
//        ];
//    }

    /**
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
//        if (Yii::$app->user->identity->username != 'admin'){
//            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
//        }
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
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
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if($user = $model->signup()){
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionResetpwd($id)
    {
        $model = new ResetpwdForm();
        if ($model->load(Yii::$app->request->post())) {
            if($adminuser = $model->resetpassword($id)){
                return $this->redirect(['index']);
            }
        }

        return $this->render('resetpwd', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $model -> password = '*';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        var_dump($model->errors);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Adminuser model.
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
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrivilege($id)
    {
        //1 找出所有权限，提供给checkboxlist

        $allPrivilegeArray = RbacItem::find()->select('name,name as value')
            ->where(['type' => '1'])->indexBy('name')
            ->asArray()
            ->column();

        //2 找出当前用户已经有的权限

        $AuthAssignment = RbacAssignment::find()->select(['item_name'])
            ->where(['user_id'=>$id])
            ->asArray()
            ->all();

        $AuthAssignmentArray = array();

        foreach ($AuthAssignment as $item){
            array_push($AuthAssignmentArray,$item['item_name']);
        }

        //3 用户提交的数据更新AuthAssignment表

        if(isset($_POST['newPri'])){
            RbacAssignment::deleteAll('user_id = :id',[":id" => $id]);

            $newPri = $_POST['newPri'];

            foreach ($newPri as $item){
                $insertModel = new RbacAssignment();

                $insertModel->item_name = $item;
                $insertModel->user_id = $id;
                $insertModel->created_at = (string)time();

                if ($insertModel->save()){
                    continue;
                }else{
                    Yii::$app->session->setFlash('danger','权限分配失败！');
                    return $this->redirect(['index']);
                }
            }
            //更新缓存
            RbacCheck::getAuthList($id,'1');

            Yii::$app->session->setFlash('success','权限分配成功！');
            return $this->redirect(['index']);
        }

        //4 渲染多选按钮
        return $this->render('privilege',['id'=>$id,'allPrivilegeArray'=>$allPrivilegeArray,'AuthAssignmentArray'=>$AuthAssignmentArray]);

    }
}

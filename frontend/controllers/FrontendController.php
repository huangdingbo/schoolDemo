<?php


namespace frontend\controllers;


use common\models\ToolModel;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class FrontendController extends Controller
{
    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * 限制访问IP
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
//           $allowedIPs = \Yii::$app->params['TaskAllowedIPs'];
//           if (!in_array(ToolModel::getIP(),$allowedIPs)){
//               throw new ForbiddenHttpException('你无权访问该页面，请联系管理员！！！');
//           }
        }
       return true;
    }
}
<?php


namespace frontend\controllers;


use common\components\RbacCheck;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class CommonController extends Controller
{
    //rbac
    protected $rbacNeedCheckActions = [];

    //acf
    protected $actions = ['*'];
    protected $except = [];
    protected $mustlogin = [];
    protected $verbs = ['delete' => ['POST']];

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){

            $route = \Yii::$app->request->get('r');

            $this->addPrefix($route);

            if (in_array($route,$this->rbacNeedCheckActions)){

                if (!RbacCheck::run($route)){
                    if (Yii::$app->request->isAjax){
                        echo Yii::$app->params['perMessage'];exit;
                    }else{
                        throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
                    }
                }
            }
        }
        return true;
    }

    private function addPrefix($route){
        $routeArr = explode('/',$route);

        $prefix = $routeArr[0];

        foreach ($this->rbacNeedCheckActions as $key => &$aitem){
            $aitem = $prefix.'/'.$aitem;
        }
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => $this->actions,
                'except' => $this->except,
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                        'roles' => ['?'], // guest
                    ],
                    [
                        'allow' => true,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => $this->verbs,
            ],
        ];
    }
}
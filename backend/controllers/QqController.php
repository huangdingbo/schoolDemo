<?php


namespace backend\controllers;


use yii\web\Controller;

class QqController extends  Controller
{
    public function actionSendEmail(){
        $mail = \YII::$app->mailer->compose('test',['t' => '222']);
        $mail->setTo("1534003110@qq.com");
        $mail->setSubject("邮件测试");
        $mail->setTextBody("1111111111111?");//发布纯文字文本
        //$mail->setHtmlBody("htmlbody");//发布可以带html标签的文本
        if($mail->send()){
          echo "success";exit;
        }else{
           echo "failure";exit;
        }
    }
}
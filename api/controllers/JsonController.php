<?php


namespace api\controllers;


use yii\web\Controller;

class JsonController extends MyController
{
    public function actionIndex(){
       $data =  include '../json/particles.json';

       $data = json_decode($data,true);

       return $data;
    }
}
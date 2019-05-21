<?php


namespace console\controllers;


use yii\db\Query;

class TestController extends CommonController
{
    public function actionIndex1(){
        for ($i = 0;$i<3;$i++){
            echo  date('Y-m-d H:i:s',time()).PHP_EOL;
            sleep(10);
        }
        return true;
    }

    public function actionIndex2(){
        for ($i = 0;$i<3;$i++){
            echo  date('Y-m-d H:i:s',time()).PHP_EOL;
            sleep(10);
        }
        return true;
    }

    public function actionIndex3(){
        for ($i = 0;$i<5;$i++){
            echo  date('Y-m-d H:i:s',time()).PHP_EOL;
            sleep(10);
        }
        return true;
    }

    public function actionIndex4(){
        for ($i = 0;$i<3;$i++){
            echo  date('Y-m-d H:i:s',time()).PHP_EOL;
            sleep(10);
        }
        return true;
    }

    public function actionIndex5(){
        for ($i = 0;$i<3;$i++){
            echo  date('Y-m-d H:i:s',time()).PHP_EOL;
            sleep(10);
        }
        return true;
    }

    public function actionIndex6(){
       try{
           (new Query())->all();
       }catch (\Exception $e){
           return ['error' => $e->getMessage()];
       }
    }

    public function actionIndex7(){
        for ($i = 0;$i<3;$i++){
            echo  date('Y-m-d H:i:s',time()).PHP_EOL;
            sleep(10);
        }
        return true;
    }

    public function actionIndex8(){
        try{
            (new Query()) -> all();

        }catch (\Exception $e){
            return ['error' => $e->getMessage()];
        }

        return true;
    }
}
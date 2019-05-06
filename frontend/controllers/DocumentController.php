<?php


namespace frontend\controllers;


use frontend\models\DocumentDownloadForm;
use frontend\models\DocumentImportForm;
use frontend\models\FileImportForm;
use frontend\models\Student;
use yii\web\Controller;
use yii\web\UploadedFile;

class DocumentController extends Controller
{
    public function actionUpload(){
        $model = new DocumentImportForm();

        if(\Yii::$app->request->isPost){
            $postData = \Yii::$app->request->post();
            $tocken = $postData['DocumentImportForm']['tocken'];
            if ($tocken != \Yii::$app->params['tocken']){
                \Yii::$app->session->setFlash('danger','Tocken不正确，请重试！！！');
                return $this->redirect(['document/upload']);
            }
            $model->load(\Yii::$app->request->post());
            //将属性封装成上传文件对象
            $model->uploader = UploadedFile::getInstance($model,'uploader');
            if ($model->validate()){
                //获取扩展名/baseName
                $baseName = $model->uploader->baseName;

                $ext = $model->uploader->getExtension();

                $file = "/document/".$baseName.'.'.$ext;

                $uploadRoot = \Yii::getAlias('@frontendExcelUpload');

                $fileName = $uploadRoot.$file;

                //保存文件
                if ($model->uploader->saveAs($fileName,false)){
                    \Yii::$app->session->setFlash('success','导入成功!!!');
                    return $this->redirect(['document/upload']);
                }

            }
        }

        return $this->render('index',[
            'model' => $model
        ]);
    }

    public function actionDownload(){
        $model = new DocumentDownloadForm();

        $files = $model->getFiles();

        if (\Yii::$app->request->isPost){
            $postData = \Yii::$app->request->post();
            $tocken = $postData['DocumentDownloadForm']['tocken'];
            if ($tocken != \Yii::$app->params['tocken']){
                \Yii::$app->session->setFlash('danger','Tocken错误，请重新输入!!!');
                return $this->redirect(['document/download']);
            }

            $fileName= $postData['DocumentDownloadForm']['fileName'];

            $fileRoot = \Yii::getAlias('@frontendExcelUpload') . '/document/' . $fileName;

            $wrstr = htmlspecialchars_decode(file_get_contents($fileRoot));

            header('Content-type: application/octet-stream; charset=utf8');
            Header("Accept-Ranges: bytes");
            header('Content-Disposition: attachment; filename='.$fileName);
            echo $wrstr;
            exit();
        }

        return $this->render('download',[
            'model' => $model,
            'files' => $files,
        ]);
    }
}
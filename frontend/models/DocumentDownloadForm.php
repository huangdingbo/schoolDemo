<?php


namespace frontend\models;


use yii\base\Model;

class DocumentDownloadForm extends Model
{
    public $tocken;
    public $fileName;
    public $capt;

    public function rules()
    {
        return [
            [['tocken','fileName'],'safe'],
            ['capt','captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tocken' => 'Tocken',
            'fileName' => '文件名',
            'capt' => '验证码'
        ];
    }

    /**
     * @return array
     * 读取文件夹下的所有文件
     */
    public function getFiles(){
        $dir = \Yii::getAlias('@frontendExcelUpload') . '/document';

        $handle=opendir($dir);
        $list = array();
        while(!!$file = readdir($handle)) {
            if (($file!=".")and($file!="..")) {
                $list[$file]=$file;
            }
        }
        closedir($handle);

        return $list;
    }
}
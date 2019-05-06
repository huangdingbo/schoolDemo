<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2019/1/29
 * Time: 17:34
 */

namespace frontend\models;


use yii\base\Model;

class DocumentImportForm extends Model
{
    public $uploader;
    public $capt;
    public $tocken;

    public function rules()
    {
        return [
            ['uploader', 'file'],
            ['capt','captcha'],
            ['tacken','safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'uploader'=>'上传文件',
            'capt' => '验证码'
        ];
    }
}
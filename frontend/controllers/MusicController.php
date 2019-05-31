<?php


namespace frontend\controllers;


use common\components\CurlTool;
use linslin\yii2\curl\Curl;
use yii\helpers\Json;
use yii\web\Controller;

class MusicController extends  Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex(){

        $getData = \Yii::$app->request->post();
        $keyword = isset($getData['keyword']) ? $getData['keyword'] : '我曾';

        $list = CurlTool::callApi('http://huangdingbo.work/school/api/web/music/get-list',['keyword' => $keyword],CurlTool::GET_TYPE)['data']['list'];

        $list = $this->dealList($list);

        return $this->render('index',['list' => json_encode($list)]);
    }

    private function dealList($list)
    {
        foreach ($list as &$value) {
            $value['title'] = $value['album_name'];
            $value['artist'] = $value['songname'];
            $value['album'] = $value['singername'];
            $value['cover'] = $this->getImgUrl($value['hash']);
            $value['mp3'] = $this->getSongUrl($value['hash']);
            $value['ogg'] = '';
        }

        return $list;
    }

    private function getSongUrl($hash){
        $curl = new Curl();

        $data = $curl->setGetParams(['hash' => $hash])->get('http://huangdingbo.work/school/api/web/music/get-url');

        $data = json_decode($data,true);

        return $data['url'];
    }

    private function getImgUrl($hash){
        $curl = new Curl();

        $data = $curl->setGetParams(['hash' => $hash])->get('http://huangdingbo.work/school/api/web/music/get-pic');

        $data = json_decode($data,true);

        $url = isset($data['list']['imgUrl']) ? $data['list']['imgUrl'] : '';

        return $url;
    }

    public function getWords($filename,$hash,$duration){
        $list = CurlTool::callApi('http://huangdingbo.work/school/api/web/music/get-word',
            [
                'filename' => $filename,
                 'hash' => $hash,
                 'duration' => $duration,
            ],CurlTool::POST_TYPE);
        var_dump($list);exit;
    }

}
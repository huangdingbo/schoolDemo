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
        $postData = \Yii::$app->request->get();
        $params = array_merge($getData,$postData);

        $keyword = isset($params['keyword']) ? $params['keyword'] : '我曾';
        $page = isset($params['page']) ? $params['page'] : '1';


        $data = CurlTool::callApi('http://huangdingbo.work/school/api/web/music/get-list',['keyword' => $keyword,'page' => $page],CurlTool::GET_TYPE);
        if ($data['data']['hasMore'] == false){
            $page = '1';
            $data = CurlTool::callApi('http://huangdingbo.work/school/api/web/music/get-list',['keyword' => $keyword,'page' => $page],CurlTool::GET_TYPE);
            $data['data']['page'] = '2';
        }
        $pager = array();
        $pager['nextPage'] = $data['data']['page'];
        $pager['totalPage'] = $data['data']['totalPage'];
        $pager['currentPage'] = $page;
        $pager['hasMore'] = $data['data']['hasMore'];
        $pager['keyword'] = $keyword;


        $list = $this->dealList($data['data']['list']);

        return $this->render('index',['list' => json_encode($list),'pager' => $pager]);
    }

    private function dealList($list)
    {
        foreach ($list as &$value) {
            $value['title'] = $value['songname'];
            $value['artist'] = $value['album_name'];
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

        $url = isset($data['list']['imgUrl']) ? $data['list']['imgUrl'] : 'http://huangdingbo.work/school/frontend/web/img/music.png';

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
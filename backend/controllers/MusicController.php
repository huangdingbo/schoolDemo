<?php


namespace backend\controllers;


use linslin\yii2\curl\Curl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class MusicController extends Controller
{
    public function actionIndex(){


        return $this->renderPartial('index');
    }

    public function actionGetSongs(){
        \Yii::$app->response->format = 'json';
        $postData = \Yii::$app->request->post();
        if (empty($postData)){
            $postData = \Yii::$app->request->get();
        }
        $keyword = $postData['keyword'] == '0' ? '我曾' : $postData['keyword'];

        $curl = new Curl();

        $data = $curl->setGetParams([
            'keyword' => $keyword
        ])->get('http://huangdingbo.work/school/api/web/music/get-list');
        $data = json_decode($data,true);

        $list = array();

        foreach ($data['data']['list'] as $key => $item){
            $list[$key]['id'] = $key+1;
            $list[$key]['title'] = $item['songname'];
            $list[$key]['singer'] = $item['singername'];
            $list[$key]['songUrl'] = $this->getSongUrl($item['hash']);
            $list[$key]['imageUrl'] = $this->getImgUrl($item['hash']);
        }

        return ['list' => $list,'ok' => true];
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
}
<?php


namespace common\components;


use linslin\yii2\curl\Curl;

class CurlTool
{
    const POST_TYPE = 'post';
    const GET_TYPE = 'get';

    public static function callApi($url,Array $params = [],$type = self::POST_TYPE,$is_array = true){
        $curl = new Curl();

        if ($type == self::POST_TYPE){
            $data = $curl->setPostParams($params)->get($url);
        }else{
            $data = $curl->setGetParams($params)->get($url);
        }

        if (is_array($data)){
            return $data;
        }

        if ($is_array === false){
            return $data;
        }

        return json_decode($data,true);
    }
}
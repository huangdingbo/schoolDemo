<?php

namespace common\components;

use Yii;

class RedisCache
{
    public static function run($key,$fallback,$timeOut = 0){
        //获取缓存组件
        $cache = Yii::$app->cache;

        //获取 $key 的缓存
        $cacheData = $cache->get($key);

        if ($cacheData){
            return json_decode($cacheData,true);
        }

        //执行回调
        $data = $fallback();

        //设置缓存
        $cache->set($key,json_encode($data),$timeOut);

        //返回数据
        return $data;
    }
}
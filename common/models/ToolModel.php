<?php


namespace common\models;


class ToolModel
{
    /**
     * @return array|false|string
     * 获取用户访问的真实IP
     */
    public static function getIP(){

        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";

        return $ip;
    }
}
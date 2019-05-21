<?php


namespace common\components;


class RegularExpression
{
    /**
     * @param $pattern  //正则表达式
     * @param $str  //匹配字符串
     * @return array  //返回结果
     * 基础正则匹配
     */
    public static function match($pattern,$str){

        preg_match($pattern,$str,$arr);

        return $arr;
    }
}
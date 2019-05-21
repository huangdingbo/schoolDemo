<?php


namespace frontend\models;


class TaskToolModel
{
    public static $status = [
        '0' => '未开始',
        '1' => '正在执行',
        '2' => '执行成功',
        '3' => '执行失败',
    ];

    public static $colors = [
        '0' => 'bg-muted',
        '1' => 'bg-primary',
        '2' => 'bg-success',
        '3' => 'bg-danger',
    ];

    public static $types = [
        '1' => '执行一次',
        '2' => '间隔执行',
        '3' => '指定时间执行',
    ];
}
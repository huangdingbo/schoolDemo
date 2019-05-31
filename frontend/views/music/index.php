<?php
//var_dump($list);exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网友Blithe分享Jquery+HTML5实现音乐播放器</title>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web')?>/css/stylesheets/style.css">
    <script src="<?=Yii::getAlias('@web')?>/js/jquery-1.7.2.min.js"></script>

</head>
<body>

<div id="background"></div>
<div id="player">
    <div class="cover"></div>
    <div class="ctrl">
        <div class="tag">
            <strong>Title</strong>
            <span class="artist">Artist</span>
            <span class="album">Album</span>
        </div>
        <div class="control">
            <div class="left">
                <div class="rewind icon"></div>
                <div class="playback icon"></div>
                <div class="fastforward icon"></div>
            </div>
            <div class="volume right">
                <div class="mute icon left"></div>
                <div class="slider left">
                    <div class="pace"></div>
                </div>
            </div>
        </div>
        <div class="progress">
            <div class="slider">
                <div class="loaded"></div>
                <div class="pace"></div>
            </div>
            <div class="timer left">0:00</div>
            <div class="right">
                <div class="repeat icon"></div>
                <div class="shuffle icon"></div>
            </div>
        </div>
    </div>
</div>
<ul id="playlist"></ul>
<!--歌词-->
<ul id="playlist">
    <li style="text-align: center"><a class="btn btn-success" href="<?=\yii\helpers\Url::to(['site/index'])?>" target="_blank">开始工作</a></li>
</ul>
<script type="text/javascript">
    var arr = eval(<?=$list?>)

</script>
<script src="<?=Yii::getAlias('@web')?>/js/jquery-ui-1.8.17.custom.min.js"></script>
<script src="<?=Yii::getAlias('@web')?>/js/script.js"></script>

</body>
</html>

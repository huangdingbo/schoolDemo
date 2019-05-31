<?php

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=\Yii::getAlias('@web')?>/fonts/iconfont.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=\Yii::getAlias('@web')?>/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?=\Yii::getAlias('@web')?>/css/player.css" />

</head>
<body>
<!-- 播放器 -->
<div class="music-player">
    <!-- audio标签 -->
    <audio class="music-player__audio" ></audio>
    <!-- 播放器主体 -->
    <div class="music-player__main">
        <!-- 模糊背景 -->
        <div class="music-player__blur"></div>
        <!-- 唱片 -->
        <div class="music-player__disc">
            <!-- 唱片图片 -->
            <div class="music-player__image">
                <img width="100%" src="" alt="">
            </div>
            <!-- 指针 -->
            <div class="music-player__pointer"><img width="100%" src="<?=\Yii::getAlias('@web')?>/images/cd_tou.png" alt=""></div>
        </div>
        <!-- 控件主体 -->
        <div class="music-player__controls">
            <!-- 歌曲信息 -->
            <div class="music__info">
                <h3 class="music__info--title">...</h3>
                <p class="music__info--singer">...</p>
            </div>
            <!-- 控件... -->
            <div class="player-control">
                <div class="player-control__content">
                    <div class="player-control__btns">
                        <div class="player-control__btn player-control__btn--prev"><i class="iconfont icon-prev"></i></div>
                        <div class="player-control__btn player-control__btn--play"><i class="iconfont icon-play"></i></div>
                        <div class="player-control__btn player-control__btn--next"><i class="iconfont icon-next"></i></div>
                        <div class="player-control__btn player-control__btn--mode"><i class="iconfont icon-loop"></i></div>
                    </div>
                    <div class="player-control__volume">
                        <div class="control__volume--icon player-control__btn"><i class="iconfont icon-volume"></i></div>
                        <div class="control__volume--progress progress"></div>
                    </div>
                </div>

                <!-- 歌曲播放进度 -->
                <div class="player-control__content">
                    <div class="player__song--progress progress"></div>
                    <div class="player__song--timeProgess nowTime">00:00</div>
                    <div class="player__song--timeProgess totalTime">00:00</div>
                </div>

            </div>

        </div>
    </div>
    <div class="search_list">
        <input type="text" value="" class="search_word">
        <input type="button" value="搜索" class="butt">
    </div>
    <!-- 歌曲列表 -->
    <div class="music-player__list">
        <ul class="music__list_content">
            <!-- <li class="music__list__item play">123</li>
            <li class="music__list__item">123</li>
            <li class="music__list__item">123</li> -->
        </ul>
    </div>
</div>

<script src="<?=\Yii::getAlias('@web')?>/js/utill.js"></script>
<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
<script src="<?=\Yii::getAlias('@web')?>/js/player.js"></script>
<script type="text/javascript">
    $(".butt").on('click',function () {
        // console.log($(".search_word").val())
        new Player($(".search_word").val());
    });
</script>
</body>
</html>
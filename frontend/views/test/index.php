是真的SB！！！！黄定波是个大撒比
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
    .table_box{width: 1000px}
    .filter_box{display: flex;position: absolute;width: 300px;height: 400px;z-index: 2;   top:50%;
        left: 50%;transform: translate(-50%,-50%);border: 1px solid black}

</style>
<div class="table_box">
    <table border="1" class="table">
        <thead>
            <tr>
                <th>节数\周数</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>1</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <th>2</th><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <th>3</th><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <th>4</th><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <th>5</th><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <th>6</th><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <th>7</th><th></th><th></th><th></th><th></th><th></th><th></th>
            </tr>

        </tbody>

    </table>
</div>
<div class="filter_box">
    <div class="filter_left">
        <div class="title">分组</div>
        <div class="list">
            <div class="list_item">1</div>
            <div class="list_item">1</div>
            <div class="list_item">1</div>
        </div>
    </div>
    <div class="filter_right">

    </div>
</div>
<script >
    $('table tbody td').click(function () {
        $('.filter_box').show();
    })

</script>
<?php
/**
 * @var $this \yii\web\View
 *
 */
$this->registerJsFile('@web/js/jquery-1.8.3.min.js')
?>

<a href="<?=\yii\helpers\Url::to(['/game/new'])?>">开始新游戏</a>
<a>查看答案</a>
<span class="num">
    <form  method="post" >
        <input type="text" name="num1"><br/>
        <input type="text" name="num2"><br/>
        <input type="text" name="num3"><br/>
        <input type="text" name="num4"><br/>
        <input type="submit" class="post" value="提交">
    </form>
</span>



<script type="text/javascript">
    $('#post').click(function(){
        console.debug(11111);
    })
</script>


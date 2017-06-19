<?php
/* @var $this yii\web\View */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?=\Yii::$app->user->can('brand/add')?\yii\bootstrap\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-default']):''?><br/><br/>
<div class="userLists">
    <table class="table table-striped table-hover">
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>简介</td>
            <td>logo</td>
            <td>排序</td>
            <td>状态</td>
            <td>操作</td>

        </tr>
        <?php foreach($brands as $brand):?>
            <tr>
                <td><?=$brand->id?></td>
                <td><?=$brand->name?></td>
                <td><?=$brand->intro?></td>
                <td><?=$brand->logo?\yii\bootstrap\Html::img($brand->logo,['width'=>40]):''?></td>
                <td><?=$brand->sort?></td>
                <td><?=$brand->status?'正常':'隐藏'?></td>
                <td>
                    <?= \Yii::$app->user->can('brand/edit')?\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$brand->id],['class'=>'btn btn-xs btn-default']):''?>
                    <?= \Yii::$app->user->can('brand/hidden')?\yii\bootstrap\Html::a('隐藏',['brand/hidden','id'=>$brand->id,['class'=>'btn btn-xs btn-default']]):''?>
                    <?=\Yii::$app->user->can('brand/delete')?\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$brand->id],['class'=>'btn btn-xs btn-default'],['onclick'=>'return notice()']):''?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
</body>
<script type="text/javascript">
    function notice(){
        return confirm('你确定要删除吗？');
    }
</script>
</html>
<?php
//echo \yii\widgets\LinkPager::widget([
//    'pagination'=>$page,
//]);
//?>
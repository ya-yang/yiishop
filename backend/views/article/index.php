<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?=\Yii::$app->user->can('article/add')?\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-default']):''?><br/><br/>
<div class="userLists">
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>简介</td>
            <td>文章分类id</td>
            <td>排序</td>
            <td>状态</td>
            <td>创建时间</td>
            <td>操作</td>

        </tr>
        <?php foreach($articles as $article):?>
            <tr>
                <td><?=$article->id?></td>
                <td><?=$article->name?></td>
                <td><?=$article->intro?></td>
                <td><?=$article->articleCategory->name?></td>
                <td><?=$article->sort?></td>
                <td><?=$article->status?'正常':'隐藏'?></td>
                <td><?=date('Y-m-d H:i:s',$article->create_time)?></td>
                <td>
                    <?=\Yii::$app->user->can('article/edit')?\yii\bootstrap\Html::a('修改',['article/edit','id'=>$article->id],['class'=>'btn btn-xs btn-default']):''?>
                    <?=\Yii::$app->user->can('article/delete')?\yii\bootstrap\Html::a('删除',['article/delete','id'=>$article->id],['class'=>'btn btn-xs btn-default'],['onclick'=>'return notice()']):''?>
                    <?=\Yii::$app->user->can('article/hidden')?\yii\bootstrap\Html::a('隐藏',['article/hidden','id'=>$article->id],['class'=>'btn btn-xs btn-default']):''?>
                    <?=\Yii::$app->user->can('article/detail')?\yii\bootstrap\Html::a('详情',['article/detail','id'=>$article->id],['class'=>'btn btn-xs btn-default']):''?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<div  class="row">

    <div class="col-md-offset-5">
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination'=>$page,
        ]);
        ?>
    </div>
</div>
</body>
<script type="text/javascript">
    function notice(){
        return confirm('你确定要删除吗？');
    }
</script>
</html>

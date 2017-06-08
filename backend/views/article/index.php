<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?=\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-default'])?><br/><br/>
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
                    <?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$article->id])?> /
                    <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$article->id],['onclick'=>'return notice()'])?> /
                    <?=\yii\bootstrap\Html::a('详情',['article/detail','id'=>$article->id])?>
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

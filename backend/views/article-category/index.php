<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?=\Yii::$app->user->can('article-category/add')?\yii\bootstrap\Html::a('添加分类',['article-category/add'],['class'=>'btn btn-default']):''?><br/><br/>
<div class="userLists">
    <table class="table table-striped table-hover">
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>简介</td>
            <td>排序</td>
            <td>状态</td>
            <td>类型</td>
            <td>操作</td>

        </tr>
        <?php foreach($articlecategorys as $articlecategory):?>
            <tr>
                <td><?=$articlecategory->id?></td>
                <td><?=$articlecategory->name?></td>
                <td><?=$articlecategory->intro?></td>
                <td><?=$articlecategory->sort?></td>
                <td><?=$articlecategory->status?'正常':'隐藏'?></td>
                <td><?=$articlecategory->is_help?'帮助文档':'非帮助文档'?></td>
                <td>
                    <?=\Yii::$app->user->can('article-category/edit')?\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$articlecategory->id],['class'=>'btn btn-xs btn-default']):''?>
                    <?=\Yii::$app->user->can('article-category/hidden')?\yii\bootstrap\Html::a('隐藏',['article-category/hidden','id'=>$articlecategory->id],['class'=>'btn btn-xs btn-default']):''?>
                    <?=\Yii::$app->user->can('article-category/delete')?\yii\bootstrap\Html::a('删除',['article-category/delete','id'=>$articlecategory->id],['class'=>'btn btn-xs btn-default'],['onclick'=>'return notice()']):''?>
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

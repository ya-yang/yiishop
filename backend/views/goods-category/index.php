<?php
/* @var $this yii\web\View */
?>
<h3>商品分类列表</h3>
<?=\yii\bootstrap\Html::a('添加分类',['goods-category/add'],['class'=>'btn btn-default']) ?>
<table class="cate table table-bordered">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>">
            <td><?=$model->id?></td>
            <td><?=str_repeat('－ ',$model->depth).$model->name?>
            <span class="toggle_cate glyphicon glyphicon-chevron-down" style="float: right"></span>
            </td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs']) ?>　
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs']) ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
$js=
    <<<JS
    $(".toggle_cate").click(function(){
        //图标切换
        $(this).toggleClass('glyphicon-chevron-down')
        $(this).toggleClass('glyphicon-chevron-up')
        //当前分类的子孙分类都应该隐藏
        var tr = $(this).closest('tr');
        var tree=parseInt(tr.attr('data-tree'));
        var lft=parseInt(tr.attr('data-lft'));
        var rgt=parseInt(tr.attr('data-rgt'));
        $('.cate tr').each(function(){
            if(parseInt($(this).attr("data-tree")) == tree && parseInt($(this).attr("data-lft"))>lft && parseInt($(this).attr("data-rgt"))<rgt){
                $(this).fadeToggle();
            }
        })
    })
JS;
$this->registerJs($js);



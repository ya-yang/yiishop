<?php
/* @var $this yii\web\View */
?>
<h1>菜单列表</h1>
<?= \Yii::$app->user->can('menu/add')?\yii\bootstrap\Html::a('添加菜单',['menu/add'],['class'=>'btn btn-default']):''?>
<table class="table">
    <thead>
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>路由</td>
        <td>上级菜单</td>
        <td>排序</td>
        <td>操作</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->label?></td>
        <td><?=$model->url?></td>
        <td><?=$model->parent_id?></td>
        <td><?=$model->sort?></td>
        <td>
            <?=\Yii::$app->user->can('menu/edit')? \yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-xs btn-default']):''?>
            <?= \Yii::$app->user->can('menu/del')?\yii\bootstrap\Html::a('删除',['menu/del','id'=>$model->id],['class'=>'btn btn-xs btn-default']):''?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({

});');
?>
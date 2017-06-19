<h3>权限列表</h3>
<?= \yii\bootstrap\Html::a('添加权限',['rbac/add-permission'],['class'=>'btn btn-default']); ?>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>权限名称</td>
        <td>权限描述</td>
        <td>操作</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($permissions as  $permission):?>
    <tr>
        <td><?=$permission->name?></td>
        <td><?=$permission->description?></td>
        <td>
            <?= \yii\bootstrap\Html::a('修改',['rbac/edit-permission','name'=>$permission->name],['class'=>'btn btn-xs btn-default']); ?>　
            <?= \yii\bootstrap\Html::a('删除',['rbac/del-permission','name'=>$permission->name],['class'=>'btn btn-xs btn-default']); ?>
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
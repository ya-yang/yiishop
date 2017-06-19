<?php
/* @var $this yii\web\View */
?>
<h3>角色列表</h3>
<?= \yii\bootstrap\Html::a('添加角色',['add-role'],['class'=>'btn btn-default']);?>
<table class="table table-striped">
    <thead>
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>权限</td>
        <td>操作</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach($roles as $role):?>
    <tr>
        <td><?=$role->name?></td>
        <td><?=$role->description?></td>
        <td><?php
            foreach (Yii::$app->authManager->getPermissionsByRole($role->name) as $permission){
                echo $permission->description;
                echo ',';
            }
            ?></td>
        <td>
            <?= \yii\bootstrap\Html::a('修改',['edit-role','name'=>$role->name],['class'=>'btn btn-default']);?>
            <?= \yii\bootstrap\Html::a('删除',['del-role','name'=>$role->name],['class'=>'btn btn-default']);?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({

});');
?>
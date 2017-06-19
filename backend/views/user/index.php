<?php
/* @var $this yii\web\View */
?>
<h1>user/index</h1>
<?= \Yii::$app->user->can('user/add')?\yii\bootstrap\Html::a('新增管理员',['user/add'],['class'=>'btn btn-default glyphicon glyphicon-user']):''?>　
<?= \yii\bootstrap\Html::a('注销登录',['user/logout'])?>
<br><br>
<table class="table table-striped">
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>注册时间</td>
        <td>最后登录IP</td>
        <td>最后登录时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>

        <td><?=$user->id?></td>
        <td><?=$user->username?></td>
        <td><?=date('Y-m-d:H:i:s',$user->created_at)?></td>
        <td><?=$user->last_login_ip?$user->last_login_ip:'-'?></td>
        <td><?=$user->last_login_time?date('Y-m-d:H:i:s',$user->last_login_time):'-'?></td>
        <td>
            <?= \Yii::$app->user->can('user/edit')?\yii\bootstrap\Html::a('修改',['user/edit','id'=>$user->id],['class'=>'btn btn-default glyphicon glyphicon-pencil']):''?>　
            <?= \Yii::$app->user->can('user/del')?\yii\bootstrap\Html::a('删除',['user/del','id'=>$user->id],['class'=>'btn btn-default glyphicon glyphicon-trash']):''?>　
            <?= \yii\bootstrap\Html::a('角色',['user/edit-role','id'=>$user->id],['class'=>'btn btn-default glyphicon glyphicon-lock'])?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>


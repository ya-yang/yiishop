<?php
/* @var $this yii\web\View */
?>

<h1>商品列表</h1>
<?php
//搜索
$form=\yii\bootstrap\ActiveForm::begin(['method'=>'get','action'=>\yii\helpers\Url::to(['goods/index']),'options'=>['class'=>'form-inline']]);
echo $form->field($search,'name')->textInput(['placeholder'=>"商品名称"])->label(false);
echo $form->field($search,'sn')->textInput(['placeholder'=>"货号"])->label(false);
echo '　'.\yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
?>

<?=\Yii::$app->user->can('goods/add')? \yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-default']):''?>
<table class="table table-hover table-striped">
    <tr>
        <td>ID</td>
        <td>商品名称</td>
        <td>货号</td>
        <td>商品价格</td>
        <td>商品库存</td>
        <td>商品LOGO</td>
        <td>创建时间</td>
        <td>操作</td>
    </tr>
    <tr>
        <?php foreach($models as $model):?>
        <td><?=$model->id ?></td>
        <td><?=$model->name ?></td>
        <td><?=$model->sn ?></td>
        <td><?=$model->shop_price ?></td>
        <td><?=$model->stock ?></td>
        <td><?=$model->logo?\yii\bootstrap\Html::img($model->logo,['width'=>40]):'' ?></td>
        <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
        <td>
            <?= \Yii::$app->user->can('goods-album/album')?\yii\bootstrap\Html::a('相册',['goods-album/album','id'=>$model->id],['class'=>'btn btn-default glyphicon glyphicon-picture']):''  ?>　
            <?= \Yii::$app->user->can('goods/edit')?\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-default glyphicon glyphicon-pencil']):''?>　
            <?= \Yii::$app->user->can('goods/del')?\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'btn btn btn-default glyphicon glyphicon-trash']):''?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
<div  class="row">

    <div class="col-md-offset-5">
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination'=>$page,
        ]);
        ?>
    </div>
</div>

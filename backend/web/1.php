<?php
//因为要根据父id去查询数据所以要接收数据
$id = isset($_GET['id'])?$_GET['id']:0;
//因为要用到数据库类所以引入类文件
require Yii::getAlias('@webroot').'/DB.class.php';
//因为要用类就必须实例化对象所以这里实例化对象
$db = DB::getInstance(['password'=>'shabi','dbname'=>'yiishop']);
//因为要查询数据所以构造sql
$sql="select * from `locations` where parent_id=".$id;
//因为要得到结果所以执行sql
$rows=$db->fetchAll($sql);
//因为要返回给前台ajax所以返回json数据
echo json_encode($rows);
?>
<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\search\service\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="item-search">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'form-inline']
        ]); ?>
        <?= $form->field($model, 'cityName', ['options' => ['class' => 'form-group col-lg-2']])->dropDownList(ArrayHelper::map($cities, 'id', 'name'), ['prompt' => '请选择城市'])->label('请选择城市', ['class' => 'sr-only']) ?>
        <?= $form->field($model, 'areaName', ['options' => ['class' => 'form-group col-lg-2']])->dropDownList(ArrayHelper::map($areas, 'id', 'name'), ['prompt' => '请选择区县'])->label('请选择区县', ['class' => 'sr-only']) ?>
        <?= $form->field($model, 'communityName', ['options' => ['class' => 'form-group col-lg-2']])->dropDownList(ArrayHelper::map($communities, 'id', 'name'), ['prompt' => '请选择小区'])->label('请选择小区', ['class' => 'sr-only']) ?>
        <div class="col-lg-2 col-lg-offset-1">
            <input class="form-control" id="keyword" placeholder="请输入小区名" value="" />
        </div>
        <div class="col-lg-1">
            <button type="button" id="search-community" class="btn btn-info">搜索</button>
        </div>
        <p></p>
        <div class="form-group col-lg-1 pull-right">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<p> </p>
<?php
$this->registerJs('
  //市地址改变
  $("#itemsearch-cityname").change(function() {
    //市id值
    var cityid = $(this).val();
    $("#itemsearch-areaname").html("<option value=\"0\">请选择区县</option>");
    $("#itemsearch-communityname").html("<option value=\"0\">请选择小区</option>");
    if (cityid > 0) {
      getArea(cityid);
    }
  });
  //区地址改变
  $("#itemsearch-areaname").change(function() {
    //区id值
    var areaid = $(this).val();
    $("#itemsearch-communityname").html("<option value=\"0\">请选择小区</option>");
    if (areaid > 0) {
      getCommunity(areaid);
    }
  });
  //获取市下面的区列表
  function getArea(id)
  {
    var href = "' . Url::to(['/service/base/get-area-list'], true). '";
    $.ajax({
      "type" : "GET",
      "url"  : href,
      "data" : {id : id},
      success : function(d) {
        $("#itemsearch-areaname").append(d);
      }
    });
  }
  //获取区下面的小区列表
  function getCommunity(id)
  {
    var href = "' . Url::to(['/service/base/get-community-list'], true) . '";
    $.ajax({
      "type" : "GET",
      "url"  : href,
      "data" : {id : id},
      success : function(d) {
        $("#itemsearch-communityname").append(d);
      }
    });
  }
  //搜索小区
  $("#search-community").click(function() {
    var word  = $("#keyword").val();
    var areaid = $("#itemsearch-areaname option:selected").val();
    var href  = "' . Url::to(['/service/base/search-community'], true) . '";
    if (areaid > 0) {
      $.ajax({
        "type" : "GET",
        "url"  : href,
        "data" : {id : areaid, word : word},
        success : function(d) {
          $("#itemsearch-communityname").html(d);
        }
      });
    }
  });
');
?>

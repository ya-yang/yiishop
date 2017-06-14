<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');

echo $form->field($model,'logo')->hiddenInput();

//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data);
        //将图片上传成功后地址(data.fileUrl)写入img标签
        $("#img_logo").attr("src",data.fileUrl).show();
        //将图片上传成功后地址(data.fileUrl)写入logo字段
        $("#goods-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\helpers\Html::img('@web'.$model->logo,['id'=>'img_logo','width'=>'100']);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','width'=>'100']);
}

echo $form->field($model,'goods_category_id')->hiddenInput();

echo '<div>
    <ul id="tree" class="ztree"></ul>
</div>';

echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrand(),['prompt'=>'=请选则分类=']);

echo $form->field($model,'market_price');

echo $form->field($model,'shop_price');

echo $form->field($model,'stock');

echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$saleoptions);

echo $form->field($model,'sort');

echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$statusoptions);

echo $form->field($intro,'content')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'en', //中文为 zh-cn
        //定制菜单
//        'toolbars' => [
//            [
//                'fullscreen', 'source', 'undo', 'redo', '|',
//                'fontsize',
//                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
//                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
//                'forecolor', 'backcolor', '|',
//                'lineheight', '|',
//                'indent', '|'
//            ],
//        ]
    ]
]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();

$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);

$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');

$js=
    <<<JS
 var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		    beforeClick: function(treeId, treeNode, clickFlag) {
		        //将选中的id值赋值给隐域parent_id;
                // console.debug(treeNode.id);
                $('#goods-goods_category_id').val(treeNode.id);
            }
	    },
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）

    var zNodes ={$categories};
    zTreeObj = $.fn.zTree.init($("#tree"), setting, zNodes);
    //展开所有节点
    zTreeObj.expandAll(true);
     //查找当前节点的父id（根据id查找）
    var node = zTreeObj.getNodeByParam("id", $('#goods-goods_category_id').val(), null);
    //选中节点
    zTreeObj.selectNode(node);
    
    
    
JS;
$this->registerJs($js);
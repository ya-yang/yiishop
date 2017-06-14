<?php
/**
 * @var $this \yii\web\View
 */
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');

echo $form->field($model,'parent_id')->hiddenInput();
echo '<div>
    <ul id="tree" class="ztree"></ul>
</div>';

echo $form->field($model,'intro')->textarea();

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-primary']);

\yii\bootstrap\ActiveForm::end();
//加载静态资源
/*<script type="text/javascript" src="/zTree/js/jquery.ztree.core.js"></script>
<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">*/
//\yii\web\JqueryAsset::className()
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
                $('#goodscategory-parent_id').val(treeNode.id);
            }
	    },
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）

    var zNodes ={$categories};
    zTreeObj = $.fn.zTree.init($("#tree"), setting, zNodes);
    //展开所有节点
    zTreeObj.expandAll(true);
//    zTreeObj.expandNode({$model->parent_id});
    
    //查找当前节点的父id（根据id查找）
    var node = zTreeObj.getNodeByParam("id", $('#goodscategory-parent_id').val(), null);
    //选中节点
    zTreeObj.selectNode(node);
    
    
JS;
$this->registerJs($js);

?>

<?php

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->widget('kucha\ueditor\UEditor',[
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

use kartik\file\FileInput;
echo $form->field($model, 'logo')->widget(FileInput::classname(), [
    'options' => ['multiple' => true],
]);


// 非ActiveForm的表单
//echo '<label class="control-label">图片</label>';
//echo FileInput::widget([
//    'model' => $model,
//    'attribute' => 'logo',
//    'options' => ['multiple' => true]
//]);

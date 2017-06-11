<?php

use \yii\web\JsExpression;
use xj\uploadify\Uploadify;

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();

echo $form->field($model,'intro')->textarea();

echo $form->field($model,'logo')->hiddenInput();

echo \yii\bootstrap\Html::fileInput('test',null,['id'=>'test']);

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
        console.log(data.fileUrl);
        //将图片上传成功后地址(data.fileUrl)写入img标签
        $("#img_logo").attr("src",data.fileUrl).show();
        //将图片上传成功后地址(data.fileUrl)写入logo字段
        $("#brand-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);

//
if($model->logo){
    echo \yii\helpers\Html::img('@web'.$model->logo,['id'=>'img_logo','height'=>'50']);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'50']);
}


echo $form->field($model,'sort')->textInput();

echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏']);


echo $form->field($model,'code')->widget(yii\captcha\Captcha::className(),['captchaAction'=>'brand/captcha','template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>']);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();

echo $form->field($model,'intro')->textarea();

echo $form->field($model,'imgFile')->fileInput();

if($model->logo){echo \yii\bootstrap\Html::img($model->logo,['width'=>40]);}

echo $form->field($model,'sort')->textInput();

echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏']);


echo $form->field($model,'code')->widget(yii\captcha\Captcha::className(),['captchaAction'=>'brand/captcha','template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>']);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
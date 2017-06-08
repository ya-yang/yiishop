<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();

echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏']);

echo $form->field($model,'imgFile')->fileInput();

if($model->photo){echo "<img src=".$model->photo." />"; };

echo $form->field($model,'status',['inline'=>true])->radioList([0=>'不在线',1=>'在线']);

echo $form->field($model,'code')->widget(yii\captcha\Captcha::className(),['captchaAction'=>'account/captcha','template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>']);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
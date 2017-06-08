<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');

echo $form->field($model,'intro')->textarea();

echo $form->field($articledetail,'content')->textarea();

echo $form->field($model, 'article_category_id')->dropDownList(yii\helpers\ArrayHelper::map($articlecategorys,'id','name'));

echo $form->field($model,'sort');

echo $form->field($model,'status',['inline'=>true])->radioList([0=>'隐藏',1=>'正常']);

//echo $form->field($model,'code')->widget(yii\captcha\Captcha::className(),['captchaAction'=>'article-category/captcha','template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>']);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-primary']);


\yii\bootstrap\ActiveForm::end();
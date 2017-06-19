<?php

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');

echo $form->field($model,'description')->textarea();

echo $form->field($model,'permissions',['inline'=>true])->checkboxList(\backend\models\RoleForm::getPermissionOptions());

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-primary']);

\yii\bootstrap\ActiveForm::end();
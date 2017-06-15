<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'username');

if(!$model->password_hash){echo $form->field($model,'password')->passwordInput();

echo $form->field($model,'repassword')->passwordInput();
}

echo $form->field($model,'email');

echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\User::$statusoption);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
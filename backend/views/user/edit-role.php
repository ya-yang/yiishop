<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'roles')->checkboxList(\backend\models\User::getRoleoptions());


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();

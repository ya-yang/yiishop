
<div class="row">
    <div class="col-lg-5">
        <?php $form = \yii\bootstrap\ActiveForm::begin();

        echo $form->field($model, 'username')->textInput(['autofocus' => true]);

        echo $form->field($model, 'password')->passwordInput();?>


        <div class="form-group">
            <?= \yii\bootstrap\Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>


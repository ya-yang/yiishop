
<div class="row">
    <div class="col-lg-5">
        <?php $form = \yii\bootstrap\ActiveForm::begin();

        echo $form->field($model, 'username')->textInput(['autofocus' => true]);

        echo $form->field($model, 'password')->passwordInput();

        echo $form->field($model,'code')->widget(yii\captcha\Captcha::className(),['captchaAction'=>'user/captcha','template'=>'<div class="row"><div class="col-lg-5">{input}</div><div class="col-lg-2">{image}</div></div>']);?>

        <?=$form->field($model,'rememberMe')->checkbox();?>

        <div class="form-group">
            <?= \yii\bootstrap\Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>



<div class="row">
    <div class="col-lg-5">
        <?php $form = \yii\bootstrap\ActiveForm::begin();

        echo $form->field($model, 'oldpasswd')->passwordInput(['autofocus' => true]);

        echo $form->field($model, 'passwd')->passwordInput();

        echo $form->field($model, 'repasswd')->passwordInput();

        echo $form->field($model,'code')->widget(yii\captcha\Captcha::className(),['captchaAction'=>'user/captcha','template'=>'<div class="row"><div class="col-lg-5">{input}</div><div class="col-lg-2">{image}</div></div>']);?>


        <div class="form-group">
            <?= \yii\bootstrap\Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>


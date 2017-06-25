<?php
/**
 *  @var $this yii\web\View
 */
?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">


            <?php
                $form=\yii\widgets\ActiveForm::begin(
                        ['fieldConfig'=>[
                                'options'=>['tag'=>'li'],
                                'errorOptions'=>['tag'=>'p']]]);
                echo '<ul>';
                echo $form->field($model,'username')->textInput(['class'=>'txt']);
                echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
                echo $form->field($model,'repassword')->passwordInput(['class'=>'txt']);
                echo $form->field($model,'email')->textInput(['class'=>'txt']);
                echo $form->field($model,'tel')->textInput(['class'=>'txt']);
                $button = '<input type="button" id="sms_button" value="获取验证码" style="height: 25px;margin: 5px"/>';
            echo $form->field($model,'smscode',[
                'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
            ])->textInput(['class'=>'txt','style'=>'width:190px']);

                echo $form->field($model,'code',['options'=>['class'=>'checkcode']])->widget(
                \yii\captcha\Captcha::className(),[
                    'template'=>'{input}{image}',
                ]
            );
                echo $form->field($model,'read',[
                        'template'=>"{label}\n{input}我已阅读并同意《用户注册协议》\n{hint}\n{error}",//输出模板
                    ])->checkbox()->label(false);


                echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitInput('',['class'=>'login_btn ']);
                echo '</li></ul>';



                \yii\widgets\ActiveForm::end();
            ?>
        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<?php
$url=\yii\helpers\Url::to(['user/send-sms']);
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
        $(function(){
             $('#member-smscode').prop('disabled',true);
        });
        $('#sms_button').click(function(){
            var tel=$('#member-tel').val();
            var username=$('#member-username').val();
            $.post('$url',{tel:tel,username:username},function(response){
                if(response == 'success'){
                    console.debug('发送成功')
                    alert('发送成功')
                }else{
                   console.debug(response)
                }
            });
            if(tel){
                //启用输入框
			$('#member-smscode').prop('disabled',false);
			var time=60;
			var interval = setInterval(function(){
				time--;
				if(time<=0){
					clearInterval(interval);
					var html = '获取验证码';
					$('#sms_button').prop('disabled',false);
				} else{
					var html = time + ' 秒后再次获取';
					$('#sms_button').prop('disabled',true);
				}
				$('#sms_button').val(html);
			},1000);
            }
            
        })

JS
));

?>

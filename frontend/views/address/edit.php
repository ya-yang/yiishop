<?php
/**
 * @var $this \yii\web\View
 */
?>

<!-- 右侧内容区域 start -->
<div class="content fl ml10">
    <div class="address_bd mt10">
        <h4>修改收货地址</h4>
        <?php
        $form=\yii\widgets\ActiveForm::begin(
            ['class'=>'address_form'],
            ['fieldConfig'=>[
                'options'=>['tag'=>'li'],

            ]]
        );
        echo '<ul>';
        echo $form->field($model,'name')->textInput(['class'=>'txt'])->label('收 货 人：').'<br/>';

        echo '<label for="">所在地区：</label>';
        echo $form->field($model,'province',['template' => "{input}",'options'=>['tag'=>false]])->dropDownList([''=>'=选择省=']);
        echo $form->field($model,'city',['template' => "{input}",'options'=>['tag'=>false]])->dropDownList([''=>'=选择市=']);
        echo $form->field($model,'area',['template' => "{input}",'options'=>['tag'=>false]])->dropDownList([''=>'=选择县=']).'<br/><br/>';

//        $url=\yii\helpers\Url::toRoute(['get-region']);
//        echo $form->field($model, 'province')->widget(\chenkby\region\Region::className(),[
//                'model'=>$model,
//                'url'=>$url,
//                'province'=>[
//                    'attribute'=>'province',
//                    'items'=>\frontend\models\Address::getRegion(),
//                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择省份']
//                ],
//                'city'=>[
//                    'attribute'=>'city',
//                    'items'=>\frontend\models\Address::getRegion($model['province']),
//                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择城市']
//                ],
//                'area'=>[
//                    'attribute'=>'area',
//                    'items'=>\frontend\models\Address::getRegion($model['city']),
//                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择县/区']
//                ]
//            ])->label('请 选 择：').'<br/>';



        echo $form->field($model,'detail')->textInput(['class'=>'txt address'])->label('详细地址：').'<br/>';
        echo $form->field($model,'tel')->textInput(['class'=>'txt'])->label('手机号码：').'<br/>';
        echo $form->field($model,'is_default')->checkbox()->label(false).'<br/><br/>';

        echo \yii\helpers\Html::submitButton('保存',['class'=>'btn']);

        echo '</ul>';
        \yii\widgets\ActiveForm::end();



        ?>

    </div>



</div>
<?php
$this->registerJsFile('@web/js/address.js');
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
        $(address).each(function() {
          var option = '<option value="'+this.name+'">'+this.name+'</option>'; 
          $('#address-province').append(option);
        });
        //选择市
        $('#address-province').change(function() {
          //获取选中的省
          var province = $(this).val();
            $(address).each(function() {
               if(this.name == province){
                   var option = '<option value="">=请选择市=</option>';
                   $(this.city).each(function(){
                        option += '<option value="'+this.name+'">'+this.name+'</option>';     
                      
                   });
                     $('#address-city').html(option);
               }
            })
        });
        $('#address-city').change(function(){
            var province=$('#address-province').val();
            var city=$(this).val();
            $(address).each(function(){
                if(this.name == province){
                    $(this.city).each(function(){
                        if(this.name == city){
                            var option = '<option value="">=请选地区=</option>';
                            $(this.area).each(function(i,v){
                                 option += '<option value="'+v+'">'+v+'</option>';     
                               });
                                $('#address-area').html(option);
                           }
                    })
                }
            })
        })
     

JS
));
$js = '';
if($model->province){
    $js .= '$("#address-province").val("'.$model->province.'");';
}
if($model->city){
    $js .= '$("#address-province").change();$("#address-city").val("'.$model->city.'");';
}
if($model->area){
    $js .= '$("#address-city").change();$("#address-area").val("'.$model->area.'");';
}
$this->registerJs($js);
?>
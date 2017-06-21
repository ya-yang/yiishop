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



        $url=\yii\helpers\Url::toRoute(['get-region']);

        echo $form->field($model, 'province')->widget(\chenkby\region\Region::className(),[
                'model'=>$model,
                'url'=>$url,
                'province'=>[
                    'attribute'=>'province',
                    'items'=>\frontend\models\Address::getRegion(),
                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择省份']
                ],
                'city'=>[
                    'attribute'=>'city',
                    'items'=>\frontend\models\Address::getRegion($model['province']),
                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择城市']
                ],
                'area'=>[
                    'attribute'=>'area',
                    'items'=>\frontend\models\Address::getRegion($model['city']),
                    'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择县/区']
                ]
            ])->label('请 选 择：').'<br/>';



        echo $form->field($model,'detail')->textInput(['class'=>'txt address'])->label('详细地址：').'<br/>';
        echo $form->field($model,'tel')->textInput(['class'=>'txt'])->label('手机号码：').'<br/>';
        echo $form->field($model,'is_default')->checkbox()->label(false).'<br/><br/>';

        echo \yii\helpers\Html::submitButton('保存',['class'=>'btn']);

        echo '</ul>';
        \yii\widgets\ActiveForm::end();



        ?>

    </div>



</div>
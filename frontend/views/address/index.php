<?php
/**
 * @var $this \yii\web\View
 */
?>

<!-- 右侧内容区域 start -->
<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>

        <?php foreach ($models as $address): ?>

        <dl>
            <dt><?=$address->id?>.<?=$address->name?>
                <?php $province=\app\models\Locations::findOne(['id'=>$address->province])?>
                <?=$province->name?>
                <?php $city=\app\models\Locations::findOne(['id'=>$address->city])?>
                <?=$city->name?>
                <?php $area=\app\models\Locations::findOne(['id'=>$address->area])?>
                <?=$area->name?>
                <?=$address->detail?>
                <?=$address->tel?>
            </dt>
            <dd>
                <?= \yii\helpers\Html::a('修改',['/address/edit','id'=>$address->id])  ?>
                <?= \yii\helpers\Html::a('删除',['address/del','id'=>$address->id])  ?>
                <?= $address->is_default?'<span style="color: red">[默认地址]</span>':\yii\helpers\Html::a('设为默认地址',['address/default','ad_id'=>$address->id])?>
            </dd>
        </dl>
        <?php endforeach; ?>
<!--        <dl class="last"> <!-- 最后一个dl 加类last -->
<!--            <dt>2.许坤 四川省 成都市 高新区 仙人跳大街 17002810530 </dt>-->
<!--            <dd>-->
<!--                <a href="">修改</a>-->
<!--                <a href="">删除</a>-->
<!--                <a href="">设为默认地址</a>-->
<!--            </dd>-->
<!--        </dl>-->

    </div>
    <div class="address_bd mt10">
        <h4>新增收货地址</h4>

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
<!--        <form action="" name="address_form">-->
<!---->
<!--            <ul>-->
<!--                <li>-->
<!--                    <label for=""><span>*</span>收 货 人：</label>-->
<!--                    <input type="text" name="" class="txt" />-->
<!--                </li>-->
<!--                <li>-->
<!--                    <label for=""><span>*</span>所在地区：</label>-->
<!--                    <select name="province">-->
<!--                        <option value="1">北京</option>-->
<!--                        <option value="2">上海</option>-->
<!--                        <option value="3">天津</option>-->
<!--                        <option value="4">重庆</option>-->
<!--                        <option value="5">武汉</option>-->
<!--                    </select>-->
<!---->
<!--                    <select name="city" id="">-->
<!--                        <option value="1">朝阳区</option>-->
<!--                        <option value="2">东城区</option>-->
<!--                        <option value="3">西城区</option>-->
<!--                        <option value="4">海淀区</option>-->
<!--                        <option value="5">昌平区</option>-->
<!--                    </select>-->
<!---->
<!--                    <select name="area" id="">-->
<!--                        <option value="1">请选择</option>-->
<!--                        <option value="2">西二旗</option>-->
<!--                        <option value="3">西三旗</option>-->
<!--                        <option value="4">三环以内</option>-->
<!--                    </select>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <label for=""><span>*</span>详细地址：</label>-->
<!--                    <input type="text" name="" class="txt address"  />-->
<!--                </li>-->
<!--                <li>-->
<!--                    <label for=""><span>*</span>手机号码：</label>-->
<!--                    <input type="text" name="" class="txt" />-->
<!--                </li>-->
<!--                <li>-->
<!--                    <label for="">&nbsp;</label>-->
<!--                    <input type="checkbox" name="" class="check" />设为默认地址-->
<!--                </li>-->
<!--                <li>-->
<!--                    <label for="">&nbsp;</label>-->
<!--                    <input type="submit" name="" class="btn" value="保存" />-->
<!--                </li>-->
<!--            </ul>-->
<!--        </form>-->
    </div>



</div>
<!-- 右侧内容区域 end -->


<?php
//加载地址数据
$js=
    <<<JS
        

JS;
$this->registerJs($js);


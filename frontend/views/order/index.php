<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile("@web/style/fillin.css");
$this->registerJsFile("@web/js/jquery-1.8.3.min.js");
$this->registerJsFile("@web/js/cart2.js");
?>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href=""><?= \yii\helpers\Html::img('@web/images/logo.png',['alt'=>'京西商城']) ?></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
<!--    //提交到本页面-->
    <form method="post">
        <div class="fillin_hd">
            <h2>填写并核对订单信息</h2>
        </div>
        <div class="fillin_bd">
            <!-- 收货人信息  start-->
            <div class="address">
                <h3>收货人信息</h3>
                <div class="address_info">
                    <?php foreach ($address as $addr): ?>
                        <p>
                            <input type="radio" value="<?=$addr->id?>" name="address_id" <?=$addr->is_default?'checked="checked"':''?>/><?=$addr->name?>  <?=$addr->tel?>  <?=$addr->province?> <?=$addr->city?> <?=$addr->area?>  <?=$addr->detail?>　　<?=$addr->is_default?'<span style="color: red">[默认地址]</span>':''?></p>
                    <?php endforeach; ?>
                </div>


            </div>
            <!-- 收货人信息  end-->

            <!-- 配送方式 start -->
            <div class="delivery">
                <h3>送货方式 </h3>
                <div class="delivery_select">
                    <table>
                        <thead>
                        <tr>
                            <th class="col1">送货方式</th>
                            <th class="col2">运费</th>
                            <th class="col3">运费标准</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach(\frontend\models\Order::$deliveries as $k=>$delivery):?>
                        <tr <?=$k?'':'class="cur"'?>>
                            <td>
                                <input type="radio" class="delivery_type" name="Order[delivery_id]" <?=$k?'':'checked="checked"'?> value="<?=$delivery['id']?>"/><?=$delivery['delivery_name']?>

                            </td>
                            <td> <?=$delivery['delivery_price']?></td>
                            <td><?=$delivery['info']?></td>
                        </tr>
                        <?php endforeach ?>

                        </tbody>
                    </table>

                </div>
            </div>
            <!-- 配送方式 end -->

            <!-- 支付方式  start-->
            <div class="pay">
                <h3>支付方式 </h3>


                <div class="pay_select">
                    <table>
                        <?php foreach (\frontend\models\Order::$payments as $k=>$payment):?>
                        <tr <?=$k?'':'class="cur"'?>>
                            <td class="col1"><input type="radio" name="Order[payment_id]" <?=$k?'':'checked="checked"'?> value="<?=$payment['id']?>"/><?=$payment['payment_name']?></td>
                            <td class="col2"><?=$payment['info']?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>

                </div>
            </div>
            <!-- 支付方式  end-->

            <!-- 发票信息 start-->
<!--            <div class="receipt none">
                <h3>发票信息 </h3>


                <div class="receipt_select ">
                    <form action="">
                        <ul>
                            <li>
                                <label for="">发票抬头：</label>
                                <input type="radio" name="type" checked="checked" class="personal" />个人
                                <input type="radio" name="type" class="company"/>单位
                                <input type="text" class="txt company_input" disabled="disabled" />
                            </li>
                            <li>
                                <label for="">发票内容：</label>
                                <input type="radio" name="content" checked="checked" />明细
                                <input type="radio" name="content" />办公用品
                                <input type="radio" name="content" />体育休闲
                                <input type="radio" name="content" />耗材
                            </li>
                        </ul>
                    </form>

                </div>
            </div>-->
            <!-- 发票信息 end-->

            <!-- 商品清单 start -->
            <div class="goods">
                <h3>商品清单</h3>
                <table>
                    <thead>
                    <tr>
                        <th class="col1">商品</th>
                        <th class="col3">价格</th>
                        <th class="col4">数量</th>
                        <th class="col5">小计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count=0 ?>
                    <?php foreach ($models as $model): $count++?>
                    <tr>
                        <td class="col1"><a href=""><?=\yii\helpers\Html::img('http://admin.yiishop.com'.$model['logo'])?></a>  <strong><a href=""><?=$model['name']?></a></strong></td>
                        <td class="col3">￥<?=$model['shop_price']?></td>
                        <td class="col4"><?=$model['amount']?></td>
                        <td class="col5">￥<span class="min_total" ><?=$model['shop_price']*$model['amount']?></span></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul>
                                <li>
                                    <span><?=$count?> 件商品，总商品金额：￥</span>
                                    <em class="total">5316.00</em>
                                </li>
                                <!--<li>
                                    <span>返现：</span>
                                    <em>-￥240.00</em>
                                </li>-->
                                <li>
                                    <span>运费：￥</span>
                                    <em class="price_delivery">10.00</em>
                                </li>
                                <li>
                                    <span>应付总额：￥</span>
                                    <em class="totalprice">5076.00</em>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- 商品清单 end -->
            <input type="hidden" name="total" class="totalprice" value="">
<!--            <input type="submit" value="提交">-->
        </div>


        <div class="fillin_ft">
            <input type="submit" style="float: right; display: inline; width: 135px; height: 36px; background: url(<?=Yii::getAlias('@web').'/images/order_btn.jpg'?>) 0 0 no-repeat; vertical-align: middle; margin: 7px 10px 0;" value=" " id="submit_button"/>
            <p>应付总额：<strong class="totalprice">￥5076.00元</strong></p>
        </div>
    </form>
</div>


<!-- 主体部分 end -->
<?php
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
        //总价格
       $(function(){
                var totalPrice = 0;
                $('.min_total').each(function() {
                  totalPrice += parseInt($(this).text())
                });
                $('.total').text(totalPrice)          
                var total=totalPrice
                var price_delivery=$('.price_delivery').text();
                var totalprice=parseInt(total)+parseInt(price_delivery);
                $('.totalprice').text(totalprice)  
                $('.totalprice').val(totalprice)  
       })
       //运费
       $('.delivery_type').change(function(){
           //获取的值
           var price=$('.delivery_type:checked').closest('tr').find('td:eq(1)').text();
            $('.price_delivery').text(price)  
            var total=$('.total').text();
            var price_delivery=price;
            var totalprice=parseInt(total)+parseInt(price_delivery);
            $('.totalprice').text(totalprice) 
            $('.totalprice').val(totalprice)  
            
            
       });
       //应付总额

       
       

JS

))
?>

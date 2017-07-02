<?php
/**
 * @var $this \yii\web\View;
 */
$this->registerCssFile('@web/style/order.css');
?>
    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="order_hd">
            <h3>我的订单</h3>
            <dl>
                <dt>便利提醒：</dt>
                <dd>待付款（0）</dd>
                <dd>待确认收货（0）</dd>
                <dd>待自提（0）</dd>
            </dl>

            <dl>
                <dt>特色服务：</dt>
                <dd><a href="">我的预约</a></dd>
                <dd><a href="">夺宝箱</a></dd>
            </dl>
        </div>

        <div class="order_bd mt10">
            <table class="orders">
                <thead>
                <tr>
                    <th width="10%">订单号</th>
                    <th width="10%">收货人</th>
                    <th width="20%">订单金额</th>
                    <th width="20%">下单时间</th>
                    <th width="10%">订单状态</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order):?>
                <tr>
                    <td><a href=""><?=$order->id?></a></td>
                    <td><?=$order->name?></td>
                    <td>￥<?=$order->total?> <?=$order->payment_name?></td>
                    <td><?=date('Y-m-d H:i:s',$order->create_time)?></td>
                    <td><?=\frontend\models\Order::$statusoptions[$order->status] ?></td>
                    <td>
                        <?=\yii\helpers\Html::a('查看',['goods','id'=>$order->id])?>  |
                        <?php
                        if($order->status == 0){
                            echo \yii\helpers\Html::a('删除',['del','id'=>$order->id]);
                        }elseif($order->status == 1){
                           echo \yii\helpers\Html::a('去付款');
                        }elseif($order->status == 2){
                            echo '待发货';
                        }elseif($order->status == 3){
                            echo \yii\helpers\Html::a('确认收货',['edit','id'=>$order->id]);
                        }else{
                            echo '完成';
                        }
                        ?>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->

<div style="clear:both;"></div>

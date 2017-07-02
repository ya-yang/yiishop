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
                <th width="20%">订单商品</th>
                <th width="10%">商品名称</th>
                <th width="20%">商品单价</th>
                <th width="20%">商品数量</th>
                <th width="20%">总价</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($order_goods as $goods):?>
                    <tr>
                        <td><a href=""><?=$goods->order_id?></a></td>
                        <td><a href=""><?=\yii\helpers\Html::img('http://admin.yiishop.com'.$goods->logo)?></a></td>
                        <td><?=$goods->goods_name?></td>
                        <td>￥<?=$goods->price?></td>
                        <td><?=$goods->amount?></td>
                        <td><?=$goods->total?></td>
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
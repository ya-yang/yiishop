<table class="table table-striped">
    <tr>
        <td>ID</td>
        <td>收货人</td>
        <td>地址</td>
        <td>电话</td>
        <td>运费</td>
        <td>付款方式</td>
        <td>总价</td>
        <td>下单时间</td>
        <td>状态</td>
    </tr>
    <?php foreach ($orders as $order):?>
    <tr>
        <td><?=$order->id?></td>
        <td><?=$order->name?></td>
        <td><?=$order->province?> <?=$order->city?> <?=$order->area?>  <?=$order->address?></td>
        <td><?=$order->tel?></td>
        <td><?=$order->delivery_name?> <?=$order->delivery_price?>元</td>
        <td><?=$order->payment_name?></td>
        <td><?=$order->total?></td>
        <td><?=date('Y-m-d H:i:s',$order->create_time)?></td>
        <td>
            <?=($order->status == 2)?(\yii\bootstrap\Html::a('待发货',['/order/update','id'=>$order->id])):(\frontend\models\Order::$statusoptions[$order->status]);?>


        </td>
    </tr>
    <?php endforeach;?>

</table>










































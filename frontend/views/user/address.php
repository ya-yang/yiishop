<?php
/**
 * @var $this \yii\web\View
 */
?>

<!-- 右侧内容区域 start -->
<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <dl>
            <dt>1.许坤 北京市 昌平区 仙人跳区 仙人跳大街 17002810530 </dt>
            <dd>
                <a href="">修改</a>
                <a href="">删除</a>
                <a href="">设为默认地址</a>
            </dd>
        </dl>
        <dl class="last"> <!-- 最后一个dl 加类last -->
            <dt>2.许坤 四川省 成都市 高新区 仙人跳大街 17002810530 </dt>
            <dd>
                <a href="">修改</a>
                <a href="">删除</a>
                <a href="">设为默认地址</a>
            </dd>
        </dl>

    </div>

    <div class="address_bd mt10">
        <h4>新增收货地址</h4>
        <form action="" name="address_form">
            <ul>
                <li>
                    <label for=""><span>*</span>收 货 人：</label>
                    <input type="text" name="" class="txt" />
                </li>
                <li>
                    <label for=""><span>*</span>所在地区：</label>
                    <select name="" id="">
                        <option value="">请选择</option>
                        <option value="">北京</option>
                        <option value="">上海</option>
                        <option value="">天津</option>
                        <option value="">重庆</option>
                        <option value="">武汉</option>
                    </select>

                    <select name="" id="">
                        <option value="">请选择</option>
                        <option value="">朝阳区</option>
                        <option value="">东城区</option>
                        <option value="">西城区</option>
                        <option value="">海淀区</option>
                        <option value="">昌平区</option>
                    </select>

                    <select name="" id="">
                        <option value="">请选择</option>
                        <option value="">西二旗</option>
                        <option value="">西三旗</option>
                        <option value="">三环以内</option>
                    </select>
                </li>
                <li>
                    <label for=""><span>*</span>详细地址：</label>
                    <input type="text" name="" class="txt address"  />
                </li>
                <li>
                    <label for=""><span>*</span>手机号码：</label>
                    <input type="text" name="" class="txt" />
                </li>
                <li>
                    <label for="">&nbsp;</label>
                    <input type="checkbox" name="" class="check" />设为默认地址
                </li>
                <li>
                    <label for="">&nbsp;</label>
                    <input type="submit" name="" class="btn" value="保存" />
                </li>
            </ul>
        </form>
    </div>

</div>
<!-- 右侧内容区域 end -->

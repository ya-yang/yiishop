<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/14
 * Time: 9:14
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "style/base.css",
        "style/global.css",
        "style/header.css",
        "style/cart.css",
        "style/footer.css"
    ];
    public $js = [
        'js/cart1.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
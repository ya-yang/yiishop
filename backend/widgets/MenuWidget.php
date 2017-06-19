<?php
namespace backend\widgets;

use backend\models\Menu;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;

class MenuWidget extends Widget
{
    public function init(){
        parent::init();
    }
    public function run(){
        NavBar::begin([
            'brandLabel' => '京西商城后台',
            'brandUrl' => \Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
        ['label' => '首页', 'url' => ['/user/indexs']],
        ];
        if (\Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' =>\Yii::$app->user->loginUrl];
        } else {
            //一级菜单
            $menus=Menu::findAll(['parent_id'=>0]);
            foreach ($menus as $menu) {
                $item=['label'=>$menu->label,'items'=>[]];
                //二级菜单
                foreach ($menu->children as $child) {
                    //有权限才添加
                    if(\Yii::$app->user->can($child->url)){
                        $item['items'][]=['label'=>$child->label,'url'=>[$child->url]];
                    }

                }

                //如果该一级菜单没有子菜单，就不显示
                if(!empty($item['items'])){
                    $menuItems[] = $item;
                }
            }
            $menuItems[] =['label' => '注销('.\Yii::$app->user->identity->username.')', 'url' =>['user/logout']];
            $menuItems[] =['label' => '修改密码','url' =>['/user/edit-passwd']];

        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }

}
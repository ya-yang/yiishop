<h1>首页</h1>
<?php
if(Yii::$app->user->isGuest){
    echo "<h3>您还没有登录请登录 --</h3>";
    echo \yii\bootstrap\Html::a('登录',Yii::$app->user->loginUrl);
}else{
    echo "<h3>欢迎你<span style='color: red'>".Yii::$app->user->identity->username."</span></h3>";
}
?>
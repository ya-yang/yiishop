<?php foreach ($categories as $k=>$category): ?>
    <div class="cat <?=$k?'':'item1'?>">
        <h3><?=\yii\helpers\Html::a($category->name,['index/list','id'=>$category->id])?> <b></b></h3>
        <div class="cat_detail">
            <?php foreach($category->children as  $k2=>$child): ?>
                <dl <?=$k2?'':'class="dl_1st"'?>>
                    <dt><?=\yii\helpers\Html::a($child->name,['index/list','id'=>$child->id])?></dt>

                    <dd>
                        <?php foreach ($child->children as $cate): ?>
                            <?=\yii\helpers\Html::a($cate->name,['index/list','id'=>$cate->id])?>
                        <?php endforeach;?>
                    </dd>
                </dl>
            <?php endforeach ;?>
        </div>
    </div>
<?php endforeach;?>
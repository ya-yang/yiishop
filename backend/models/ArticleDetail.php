<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_detail".
 *
 * @property integer $id
 * @property string $content
 */
class ArticleDetail extends \yii\db\ActiveRecord
{
    public function getArticle(){

        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章id',
            'content' => '文章内容',
        ];
    }
}

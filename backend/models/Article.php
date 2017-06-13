<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    public function getArticleCategory(){
        //hasOne的第一个参数类名，第二参数 键值对 k表示这个类的主键，v代表当前对象的关联id
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    public function getArticleDetail(){
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'intro', 'article_category_id', 'sort', 'status'], 'required'],
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'article_category_id' => '文章分类id',
            'sort' => '排序',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }
    public static function getCategorys(){
        return ArrayHelper::map(ArticleCategory::find()->where(['status'=>1])->asArray()->all(),'id','name');
    }

    public function  beforeSave($insert){
        if($insert){
            $this->create_time=time();
        }
        return parent::beforeSave($insert);
    }
}

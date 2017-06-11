<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{


    //验证码
    public $code;
    //定义场景常量
    const SCENARIO_ADD='add';
    const SCENARIO_EDIT='edit';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'intro', 'sort', 'status','code'], 'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
//            //图片验证规则
//            ['imgFile','file','extensions'=>['jpg','jpeg','png','gif']],
//
            //图片验证规则 ADD
//            ['imgFile','file','extensions'=>['jpg','jpeg','png','gif'],'skipOnEmpty'=>false,'on'=>self::SCENARIO_ADD],
//            //图片验证规则 EDT
//            ['imgFile','file','extensions'=>['jpg','jpeg','png','gif'],'skipOnEmpty'=>true,'on'=>self::SCENARIO_EDIT],
            //验证码规则
            ['code','captcha','captchaAction'=>'brand/captcha'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
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
            'logo' => 'LOGO图片',
            'sort' => '排序',
            'status' => '状态',
            'code'=>'验证码',
        ];
    }
}

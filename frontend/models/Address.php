<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $detail
 * @property string $tel
 * @property integer $is_default
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'is_default'], 'integer'],
            [['name', 'province', 'city', 'area', 'detail', 'tel'], 'required'],
            [['name', 'province', 'city', 'area'], 'string', 'max' => 50],
            [['detail'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            //验证电话
            ['tel','match','pattern'=>'/^1[3,4,5,7,8,9]\d{9}$/','message'=>'手机号码格式不正确'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'name' => '收货人',
            'province' => '省',
            'city' => '市',
            'area' => '县',
            'detail' => '详细地址',
            'tel' => '手机号码',
            'is_default' => '默认地址',
        ];
    }
    public static function getRegion($parentId=0)
    {
        $result = static::find()->from('locations')->where(['parent_id'=>$parentId])->asArray()->all();
        return ArrayHelper::map($result, 'id', 'name');
    }

}

<?php


namespace backend\models;



use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class GoodsSearchForm extends Model
{
    public $name;
    public $sn;
    public function rules(){
        return [
            ['name','string','max'=>50],
            ['sn','string'],
        ];
    }
    public function search(ActiveQuery $query)
    {
        $this->load(\Yii::$app->request->get());
        if($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
    }


}
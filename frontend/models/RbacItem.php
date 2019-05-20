<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "rbac_item".
 *
 * @property int $id
 * @property int $name
 * @property int $type
 * @property string $description
 * @property int $rule_id
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 */
class RbacItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rbac_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'description'], 'required'],
            [[ 'type', 'rule_id'], 'integer'],
            [['description', 'data'], 'string', 'max' => 500],
            [['created_at', 'updated_at'], 'string', 'max' => 50],
            [['name'],'string','max'=>64]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '路由',
            'type' => '类型',
            'description' => '描述',
            'rule_id' => '规则',
            'data' => '规则数据',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

//    public function beforeValidate()
//    {
//        if (parent::beforeValidate()){
//            $this->type = '1';
//
//            return true;
//        }
//        return false;
//    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)){
            if ($insert){
                $this->updated_at = time();
                $this->created_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }

        return false;
    }
}

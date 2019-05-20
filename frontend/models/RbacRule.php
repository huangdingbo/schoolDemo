<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "rbac_rule".
 *
 * @property int $item_id
 * @property string $name
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 */
class RbacRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rbac_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'data'], 'required'],
            [['name', 'data', 'created_at', 'updated_at'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'item_id',
            'name' => '规则名',
            'data' => '规则数据',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if ( parent::beforeSave($insert)){
            if ($insert){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }

        return false;
    }
}

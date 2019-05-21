<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "rbac_item_child".
 *
 * @property int $id
 * @property string $parent
 * @property string $child
 */
class RbacItemChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rbac_item_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }
}

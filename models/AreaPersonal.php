<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_personal".
 *
 * @property integer $area_id
 * @property integer $user_id
 * @property integer $permission
 *
 * @property Areas $area
 * @property Users $user
 */
class AreaPersonal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area_personal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'user_id', 'permission'], 'required'],
            [['area_id', 'user_id', 'permission'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'Area ID',
            'user_id' => 'User ID',
            'permission' => 'Permission',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Areas::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

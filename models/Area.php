<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Areas".
 *
 * @property string $id
 * @property string $area_id
 * @property string $id_responsable
 * @property string $name
 * @property string $description
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'id_responsable'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 150],
            [['id_responsable'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area_id' => 'Area ID',
            'id_responsable' => 'Id Responsable',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}

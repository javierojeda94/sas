<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attached_files".
 *
 * @property string $request_id
 * @property string $url
 *
 * @property Request $request
 */
class AttachedFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attached_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'url'], 'required'],
            [['request_id'], 'integer'],
            [['url'], 'string', 'max' => 100],
            [['url'], 'unique'],

        ];


    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'request_id' => Yii::t('app', 'Request ID'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

    public function upload()
    {

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}

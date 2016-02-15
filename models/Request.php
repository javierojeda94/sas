<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property string $id
 * @property string $area_id
 * @property string $user_id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $description
 * @property string $creation_date
 * @property string $completion_date
 * @property string $status
 * @property string $scheduled_start_date
 * @property string $scheduled_end_date
 * @property string $token
 *
 * @property AreasRequest[] $areasRequests
 * @property Area[] $areas
 * @property AttachedFiles[] $attachedFiles
 * @property CategoryRequest[] $categoryRequests
 * @property Category[] $categories
 * @property Chat[] $chats
 * @property Area $area
 * @property User $user
 * @property UsersRequest[] $usersRequests
 * @property User[] $users
 */
class Request extends \yii\db\ActiveRecord
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'name', 'email', 'subject', 'description'], 'required'],
            [['area_id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['creation_date', 'completion_date', 'scheduled_start_date', 'scheduled_end_date'], 'safe'],
            [['name', 'email'], 'string', 'max' => 150],
            [['subject', 'token'], 'string', 'max' => 100],
            [['verifyCode'], 'captcha', 'on' => 'captchaRequired'],
            [['status'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area_id' => Yii::t('app', 'Area'),
            'user_id' => Yii::t('app', 'Assing Responsable'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'description' => Yii::t('app', 'Description'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'completion_date' => Yii::t('app', 'Completion Date'),
            'status' => Yii::t('app', 'Status'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'scheduled_start_date' => Yii::t('app', 'Scheduled Start Date'),
            'scheduled_end_date' => Yii::t('app', 'Scheduled End Date'),
            'token' => Yii::t('app', 'Token'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasRequests()
    {
        return $this->hasMany(AreasRequest::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Areas::className(), ['id' => 'area_id'])->viaTable('areas_request', ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachedFiles()
    {
        return $this->hasMany(AttachedFiles::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryRequests()
    {
        return $this->hasMany(CategoryRequest::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('category_request', ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['request_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersRequests()
    {
        return $this->hasMany(UsersRequest::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('users_request', ['request_id' => 'id']);
    }
}

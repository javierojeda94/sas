<?php

namespace app\models;

use Yii;
use app\models\AttachedFiles;


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
 * @property string $satisfaccion
 * @property string $level
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
    public $category_id;
    public $verifyCode;
    public $requestFiles;
    public $fileNameAttached;

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
            [['area_id','category_id' ,'user_id', 'level'], 'integer'],
            [['description'], 'string'],
            [['creation_date', 'completion_date', 'scheduled_start_date', 'scheduled_end_date'], 'safe'],
            [['name', 'email'], 'string', 'max' => 150],
            [['subject', 'token'], 'string', 'max' => 100],
            [['verifyCode'], 'captcha', 'on' => 'captchaRequired'],
            [['status'], 'string', 'max' => 50],
            [['requestFiles'], 'file', 'skipOnEmpty' => true, 'extensions'=>'pdf,png,jpg,jpeg,bmp,doc,docx', 'maxFiles' => 10],
            [['fileNameAttached', 'status'], 'string', 'max' => 50],
            [['satisfaccion'], 'string', 'max' => 50],

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
            'category_id' => Yii::t('app', 'Category'),
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
        return $this->hasMany(Area::className(), ['id' => 'area_id'])->viaTable('areas_request', ['request_id' => 'id']);
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
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('category_request', ['request_id' => 'id']);
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
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('users_request', ['request_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if(!Yii::$app->user->isGuest){
                $this->user_id = Yii::$app->user->id;
            }

            if($this -> status == 'Finalizado'){
                $formatedDateTime = date_format(date_create(),"Y/m/d H:i:s");
                $this -> completion_date = $formatedDateTime;
            }
            if($this->isNewRecord){
                $formatedDateTime = date_format(date_create(),"Y/m/d H:i:s");
                $this->creation_date = $formatedDateTime;
            }

            if(empty($this->status))
            {
                $this->status="Nuevo";
            }
            return true;
        }
        return true; // TODO: Change the autogenerated stub
    }

    public function upload(){

        foreach ( $this->requestFiles as $file )
        {
            $this->fileNameAttached = $file->baseName . '.' . $file->extension;
            $file->saveAs( 'uploads/'.$this->fileNameAttached );

            $attachedFiles = new AttachedFiles();
            $attachedFiles->request_id = $this->id;
            $attachedFiles->url = $this->fileNameAttached;
            $attachedFiles->save();
        }
    }

    /**
     * @return String
     */
    public function getStringOfCategories(){
        $categoriesString  = null;
        foreach($this->categories as $category){
            if($categoriesString == null){
                $categoriesString = $category->name;
            }else{
                $categoriesString .= ",".$category->name;
            }
        }
        return $categoriesString;
    }
}

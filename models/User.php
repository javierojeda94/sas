<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $lastname
 * @property string $hash_password
 * @property string $user_name
 * @property string $email
 * @property string $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'lastname', 'hash_password', 'user_name', 'email'], 'required'],
            [['hash_password'], 'required', 'except' => ['update']],
            [['first_name', 'lastname', 'user_name'], 'string', 'max' => 128],
            [['hash_password'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'Name'),
            'lastname' => Yii::t('app', 'Lastname'),
            'hash_password' => Yii::t('app', 'Password'),
            'user_name' => Yii::t('app', 'UserName'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
                $this->hash_password = Yii::$app->getSecurity()->generatePasswordHash($this->hash_password);
            }
            else
            {
                if(!empty($this->hash_password))
                {
                    $this->hash_password = Yii::$app->getSecurity()->generatePasswordHash($this->hash_password);
                }
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::find()->all() as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by user_name
     *
     * @param  string $user_name
     * @return static|null
     */
    public static function findByUserName($user_name)
    {
        return self::findOne(['user_name'=>$user_name]);
    }

    public static function findIdUserName($id){
        return User::findOne(['id'=>$id]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUserName(){
        return $this->user_name;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->hash_password;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password,$this->hash_password);
    }

    public function getRequestAttended($id, $startDate, $endDate){
        UsersRequest::find()->joinWith('request')->where(['user_id' => $id])->andWhere(['>=', 'completion_date', $startDate])
            ->andWhere(['<=', 'completion_date', $endDate])->groupBy('user_id');
    }
}
